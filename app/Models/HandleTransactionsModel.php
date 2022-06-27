<?php

namespace App\Models;

class HandleTransactionsModel
{
    function convertAmountToFloat(string $amount): float
    {
        return (float)str_replace(['$', ','], '', $amount);
    }

    function convertDate(string $oldDate): string
    {
        $newDate = date('M j, Y', strtotime($oldDate));
        return $newDate;
    }
}