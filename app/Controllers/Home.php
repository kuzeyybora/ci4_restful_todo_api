<?php

namespace App\Controllers;

use App\Services\RedisService;
class Home extends BaseController
{
    protected RedisService $redisService;

    public function __construct()
    {
        $this->redisService = new RedisService();
    }
    public function index()
    {
        echo $this->redisService->ping();
    }
}
