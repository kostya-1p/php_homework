<?php

namespace App\Models;

use App\Model;

class FetchTransactionsModel extends Model
{
    public function selectData(): bool|array
    {
        $query = "SELECT * FROM transactions";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll();
    }
}