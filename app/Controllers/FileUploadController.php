<?php

namespace App\Controllers;

use App\View;

class FileUploadController
{
    public function index(): View
    {
        return View::make('upload');
    }
}