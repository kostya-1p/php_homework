<?php

namespace App\Models;

use App\Model;

define('DATE_INDEX', 0);
define('CHECK_INDEX', 1);
define('DESCRIPTION_INDEX', 2);
define('AMOUNT_INDEX', 3);

class FileUploadModel extends Model
{
    public function upload(string $fileName, HandleTransactionsModel $handleModel)
    {
        $unhandledTransactions = $this->readCsvFile($fileName);
        $handledTransactions = $handleModel->handleTransactions($unhandledTransactions);
        $this->insertData($handledTransactions);
    }

    private function insertData(array $transactions)
    {
        $query = "INSERT INTO transactions (date, check_num, description, amount)
                  VALUES (:date, :check_num, :desription, :amount);";
        $stmt = $this->db->prepare($query);

        foreach ($transactions as $transaction) {
            $stmt->execute([$transaction[DATE_INDEX], $transaction[CHECK_INDEX], $transaction[DESCRIPTION_INDEX], $transaction[AMOUNT_INDEX]]);
        }
    }

    private function getLineCsv($stream): array|false
    {
        return fgetcsv($stream, 1000, ",");
    }

    private function readCsvFile(string $fileName): array
    {
        $data = [];

        if (($handle = fopen($fileName, "r")) !== false) {
            $keys = $this->getLineCsv($handle);
            while (($line = $this->getLineCsv($handle)) !== false) {
                $data[] = $line;
            }
            fclose($handle);
        }

        return $data;
    }
}