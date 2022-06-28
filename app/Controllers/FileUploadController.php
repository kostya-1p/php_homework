<?php

namespace App\Controllers;

use App\Models\FileUploadModel;
use App\Models\HandleTransactionsModel;
use App\View;

class FileUploadController
{
    public function index(): View
    {
        return View::make('upload');
    }

    public function upload()
    {
        $filePath = $_FILES['table']['tmp_name'];

        $uploadModel = new FileUploadModel();
        $handleModel = new HandleTransactionsModel();
        $uploadModel->upload($filePath, $handleModel);

        header("Location: /");
    }
}