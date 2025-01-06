<?php

namespace App\Controllers;

use App\Constants\TranslationKeys;
use App\Services\AdminService;
use App\Services\FriendshipService;
use App\Services\MongoDBService;
use App\Services\RedisService;
use App\Services\TaskService;
use App\Services\TranslationService;
use App\Services\ValidationService;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    /** @var AdminService  */
    public object $adminService;
    public function __construct()
    {
        $this->adminService = service("adminService");
    }

    public function index()
    {
        // Pagination And Filters
        // Audit Logs
        return response_success($this->adminService->listLogs());
    }

    public function listUsers(): ResponseInterface
    {
        return response_success($this->adminService->listUsers());

    }

    public function listLogs(): ResponseInterface
    {
        return response_success($this->adminService->listLogs());
    }

    public function listFriendships(): ResponseInterface
    {
        return response_success($this->adminService->listFriendships());
    }

    public function listTasks(): ResponseInterface
    {
        return response_success($this->adminService->listTasks());
    }

    public function listQueues(): ResponseInterface
    {
        return response_success($this->adminService->listQueues());
    }

    public function listTaskUsers(): ResponseInterface
    {
        return response_success($this->adminService->listTaskUsers());
    }

    public function listTranslations($locale): ResponseInterface
    {
        return response_success($this->adminService->listTranslations($locale));
    }
}
