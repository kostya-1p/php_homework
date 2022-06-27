<?php

namespace App\Models;

use App\Model;

class FileUploadModel extends Model
{
    private function insertData()
    {

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