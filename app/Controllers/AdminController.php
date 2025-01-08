<?php

namespace App\Controllers;

use App\Services\AdminService;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    /** @var AdminService  */
    public object $adminService;
    public function __construct()
    {
        $this->adminService = service("adminService");
    }
    /**
     * Retrieves a list of all users.
     *
     * @return ResponseInterface A response containing the list of users.
     */
    public function listUsers(): ResponseInterface
    {
        return response_success($this->adminService->listUsers());
    }

    /**
     * Retrieves a list of logs.
     *
     * @return ResponseInterface A response containing the list of logs.
     */
    public function listLogs(): ResponseInterface
    {
        return response_success($this->adminService->listLogs());
    }

    /**
     * Retrieves a list of friendships.
     *
     * @return ResponseInterface A response containing the list of friendships.
     */
    public function listFriendships(): ResponseInterface
    {
        return response_success($this->adminService->listFriendships());
    }

    /**
     * Retrieves a list of tasks.
     *
     * @return ResponseInterface A response containing the list of tasks.
     */
    public function listTasks(): ResponseInterface
    {
        return response_success($this->adminService->listTasks());
    }

    /**
     * Retrieves a list of queues.
     *
     * @return ResponseInterface A response containing the list of queues.
     */
    public function listQueues(): ResponseInterface
    {
        return response_success($this->adminService->listQueues());
    }

    /**
     * Retrieves a list of task users.
     *
     * @return ResponseInterface A response containing the list of task users.
     */
    public function listTaskUsers(): ResponseInterface
    {
        return response_success($this->adminService->listTaskUsers());
    }

    /**
     * Retrieves a list of translations for the specified locale.
     *
     * @param string $locale The locale for which translations are to be retrieved.
     * @return ResponseInterface A response containing the list of translations.
     */
    public function listTranslations(string $locale): ResponseInterface
    {
        return response_success($this->adminService->listTranslations($locale));
    }

}
