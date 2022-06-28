<?php

namespace App\Models;

class HandleTransactionsModel
{
    public function handleTransactions(array $unhandledTransactions): array
    {
        foreach ($unhandledTransactions as $key => $value) {
            $unhandledTransactions[$key][AMOUNT_INDEX] = $this->convertAmountToFloat($value[AMOUNT_INDEX]);
            $unhandledTransactions[$key][DATE_INDEX] = $this->convertDate($value[DATE_INDEX]);
        }

        return $unhandledTransactions;
    }

    private function convertAmountToFloat(string $amount): float
    {
        return (float)str_replace(['$', ','], '', $amount);
    }

    private function convertDate(string $oldDate): string
    {
        $newDate = date('M j, Y', strtotime($oldDate));
        return $newDate;
    }

    public function getHtmlTable(array $tableData): string
    {
        $htmlTable = '';

        foreach ($tableData as $row) {
            $htmlTable = $htmlTable . '<tr>';
            $htmlTable = $htmlTable . '<td>' . $row['date'] . '</td>';
            $htmlTable = $htmlTable . '<td>' . $row['check_num'] . '</td>';
            $htmlTable = $htmlTable . '<td>' . $row['description'] . '</td>';
            $htmlTable = $htmlTable . '<td>' . $this->getAmountHtml($row['amount']) . '</td>';
            $htmlTable = $htmlTable . '</tr>';
        }

        return $htmlTable;
    }

    private function getAmountHtml(float $amount): string
    {
        $amount_html = '';

        if ($amount >= 0) {
            $amount_html = '<span style="color: green;">';

        } else {
            $amount_html = '<span style="color: red;">';
        }

        $amount_html .= $this->formatDollarAmount($amount);
        $amount_html .= '</span>';
        return $amount_html;
    }

    private function formatDollarAmount(float $amount): string
    {
        $isNegative = $amount < 0;

        return ($isNegative ? '-' : '') . '$' . number_format(abs($amount), 2);
    }

    public function getTotalIncome(array $transactions): float
    {
        $incomes = $this->filterTransactions($transactions, false);
        $incomesConverted = $this->convertAmountsInArray($incomes);

        $total = array_reduce($incomesConverted, fn($sum, $amount) => $sum + $amount);
        return $total;
    }

    public function getTotalExpense(array $transactions): float
    {
        $expenses = $this->filterTransactions($transactions, true);
        $expensesConverted = $this->convertAmountsInArray($expenses);

        return array_reduce($expensesConverted, fn($sum, $amount) => $sum + $amount);
    }

    public function getNetTotal(array $transactions): float
    {
        return $this->getTotalIncome($transactions) + $this->getTotalExpense($transactions);
    }

    private function convertAmountsInArray(array $transactions): array
    {
        return array_map(fn($row) => $row['amount'] = (float)str_replace(['$', ','], '', $row['amount']), $transactions);
    }

    private function filterTransactions(array $transactions, bool $isExpense): array
    {
        return array_filter($transactions, fn($row) => str_contains($row['amount'], '-') === $isExpense);
    }
}