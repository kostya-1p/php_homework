<?php

declare(strict_types=1);

define('DATE_INDEX', 0);
define('CHECK_INDEX', 1);
define('DESCRIPTION_INDEX', 2);
define('AMOUNT_INDEX', 3);

function filter_transactions(array $transactions, bool $isExpense): array
{
    return array_filter($transactions, fn($row) => str_contains($row[AMOUNT_INDEX], '-') === $isExpense);
}

function convert_amount_to_float(array $transactions): array
{
    return array_map(fn($row) => $row[AMOUNT_INDEX] = floatval($row[AMOUNT_INDEX]), $transactions);
}

function get_total_income(array $transactions): float
{

}

function get_html_table(array $tableData): string
{
    $htmlTable = '';

    foreach ($tableData as $row) {
        $htmlTable = $htmlTable . '<tr>';
        $htmlTable = $htmlTable . '<td>' . $row[DATE_INDEX] . '</td>';
        $htmlTable = $htmlTable . '<td>' . $row[CHECK_INDEX] . '</td>';
        $htmlTable = $htmlTable . '<td>' . $row[DESCRIPTION_INDEX] . '</td>';
        $htmlTable = $htmlTable . '<td>' . $row[AMOUNT_INDEX] . '</td>';
        $htmlTable = $htmlTable . '</tr>';
    }

    return $htmlTable;
}

function read_all_csv_files(string $directory): array
{
    $dirIterator = new DirectoryIterator($directory);
    $all_data = [];

    foreach ($dirIterator as $file) {
        if (!$file->isDot()) {
            $data = read_csv_file($directory . $file->getFilename());
            $all_data = array_merge($all_data, $data);
        }
    }

    return $all_data;
}

function read_csv_file(string $fileName): array
{
    $data = [];

    if (($handle = fopen($fileName, "r")) !== false) {
        $keys = get_line_csv($handle);
        while (($line = get_line_csv($handle)) !== false) {
            $data[] = $line;
        }
        fclose($handle);
    }

    return $data;
}

function get_line_csv($stream): array|false
{
    return fgetcsv($stream, 1000, ",");
}