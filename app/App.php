<?php

declare(strict_types=1);

define('DATE_INDEX', 0);
define('CHECK_INDEX', 1);
define('DESCRIPTION_INDEX', 2);
define('AMOUNT_INDEX', 3);

function formatDollarAmount(float $amount): string
{
    $isNegative = $amount < 0;

    return ($isNegative ? '-' : '') . '$' . number_format(abs($amount), 2);
}

function filter_transactions(array $transactions, bool $isExpense): array
{
    return array_filter($transactions, fn($row) => str_contains($row[AMOUNT_INDEX], '-') === $isExpense);
}

function convert_amount_to_float(array $transactions): array
{
    return array_map(fn($row) => $row[AMOUNT_INDEX] = (float)str_replace(['$', ','], '', $row[AMOUNT_INDEX]), $transactions);
}

function get_total_income(array $transactions): float
{
    $incomes = filter_transactions($transactions, false);
    $incomesConverted = convert_amount_to_float($incomes);

    $total = array_reduce($incomesConverted, fn($sum, $amount) => $sum + $amount);
    return $total;
}

function get_total_expense(array $transactions): float
{
    $expenses = filter_transactions($transactions, true);
    $expensesConverted = convert_amount_to_float($expenses);

    return array_reduce($expensesConverted, fn($sum, $amount) => $sum + $amount);
}

function get_net_total(array $transactions): float
{
    return get_total_income($transactions) + get_total_expense($transactions);
}

function get_html_table(array $tableData): string
{
    $htmlTable = '';

    foreach ($tableData as $row) {
        $htmlTable = $htmlTable . '<tr>';
        $htmlTable = $htmlTable . '<td>' . convert_date($row[DATE_INDEX]) . '</td>';
        $htmlTable = $htmlTable . '<td>' . $row[CHECK_INDEX] . '</td>';
        $htmlTable = $htmlTable . '<td>' . $row[DESCRIPTION_INDEX] . '</td>';
        $htmlTable = $htmlTable . '<td>' . $row[AMOUNT_INDEX] . '</td>';
        $htmlTable = $htmlTable . '</tr>';
    }

    return $htmlTable;
}

function convert_date(string $oldDate): string
{
    $newDate = date('M j, Y', strtotime($oldDate));
    return $newDate;
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