<?php

declare(strict_types = 1);



function read_csv_file(string $fileName): array {
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

function get_line_csv($stream): array|false {
    return fgetcsv($stream, 1000, ",");
}

