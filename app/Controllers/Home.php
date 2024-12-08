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
        $testModel = model("TaskUserModel");
        $test = $testModel->getUserTasks(auth()->id());
        return response_success($test, TranslationKeys::LANGUAGE_UNSUPPORTED);
    }
}
