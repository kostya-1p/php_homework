<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\FetchTransactionsModel;
use App\Models\HandleTransactionsModel;
use App\View;

class HomeController
{
    private HandleTransactionsModel $handleModel;
    private FetchTransactionsModel $fetchTransactionsModel;
    private array $transactions = [];

    public function __construct()
    {
        $this->handleModel = new HandleTransactionsModel();
        $this->fetchTransactionsModel = new FetchTransactionsModel();
    }

    public function index(): View
    {
        $this->transactions = $this->fetchTransactionsModel->selectData();
        if (empty($this->transactions)) {
            return View::make('index');
        } else {
            return View::make('transactions', [$this->getHtmlTable(), $this->getTotalIncome(), $this->getTotalExpense(), $this->getTotalNet()]);
        }
    }

    public function getHtmlTable(): string
    {
        return $this->handleModel->getHtmlTable($this->transactions);
    }

    public function getTotalIncome(): string
    {
        $totalFloat = $this->handleModel->getTotalIncome($this->transactions);
        return $this->handleModel->formatDollarAmount($totalFloat);
    }

    public function getTotalExpense(): string
    {
        $totalFloat = $this->handleModel->getTotalExpense($this->transactions);
        return $this->handleModel->formatDollarAmount($totalFloat);
    }

    public function getTotalNet(): string
    {
        $totalFloat = $this->handleModel->getNetTotal($this->transactions);
        return $this->handleModel->formatDollarAmount($totalFloat);
    }
}
