<?php

namespace App\Controllers;

use App\Constants\TranslationKeys;
use App\Services\RedisService;
class Home extends BaseController
{
    protected RedisService $redisService;

    public function __construct()
    {
        helper("response");
    }
    public function index()
    {
        return response_success(message: TranslationKeys::CREATE_SUCCESS);
    }
}
