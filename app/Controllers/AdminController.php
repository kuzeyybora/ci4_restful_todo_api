<?php

namespace App\Controllers;

use App\Constants\TranslationKeys;

class AdminController extends BaseController
{
    public function index()
    {
        return response_success(message: TranslationKeys::SUCCESS);
    }
}
