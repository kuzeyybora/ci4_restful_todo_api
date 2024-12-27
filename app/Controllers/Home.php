<?php

namespace App\Controllers;

use App\Constants\TranslationKeys;
use App\Models\TaskModel;
use App\Services\RedisService;
class Home extends BaseController
{
    protected RedisService $redisService;
    private $taskModel;
    public function __construct()
    {
        $this->taskModel = model('TaskModel');
        helper("response");
        helper('validation');
    }
    public function index()
    {
        $task = $this->taskModel->find(1);

        return response_success([$task->isCompleted()]);
    }
}
