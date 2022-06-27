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
}