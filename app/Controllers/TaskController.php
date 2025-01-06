<?php

namespace App\Controllers;

use App\Constants\TranslationKeys;
use App\Services\TaskService;
use App\Services\ValidationService;
use CodeIgniter\HTTP\ResponseInterface;

class TaskController extends BaseController
{
    /** @var ValidationService */
    private object $validationService;

    /** @var TaskService */
    private object $taskService;

    public function __construct()
    {
        $this->taskService = service('taskService');
        $this->validationService = service('validationService');
    }

    /**
     * Get all tasks for the authenticated user.
     *
     * @param int $limit The maximum number of items to display per page.
     * @param int $page The current page number being requested.
     *
     * @return ResponseInterface
     */
    public function index(int $limit = 10, int $page = 1): ResponseInterface
    {
        $query = $this->taskService->getAllUserTasks($limit, $page);

        return $query
            ? response_success($query, TranslationKeys::SUCCESS)
            : response_fail(message: TranslationKeys::NOT_FOUND);
    }

    /**
     * Get a specific task for the authenticated user.
     *
     * @param int $task_id The ID of the task to retrieve.
     * @return ResponseInterface
     */
    public function show(int $task_id = 0): ResponseInterface
    {
        $query = $this->taskService->getUserTask($task_id);

        return $query
            ? response_success($query, TranslationKeys::SUCCESS)
            : response_fail(message: TranslationKeys::NOT_FOUND);
    }

    /**
     * Create a new task for the authenticated user.
     *
     * @return ResponseInterface
     */
    public function create(): ResponseInterface
    {
        $requestData = $this->validationService->validateAndSanitize($this->request->getJSON(true), 'task_create_rules');

        if (!$requestData->status) {
            return response_fail(message: TranslationKeys::VALIDATION_FAIL, data: $requestData->errors);
        }

        $taskCreated = $this->taskService->createTask($requestData->data);

        return $taskCreated
            ? response_success(message: TranslationKeys::CREATE_SUCCESS)
            : response_fail(TranslationKeys::CREATE_FAIL);
    }

    /**
     * Update an existing task for the authenticated user.
     *
     * @param int $task_id The ID of the task to update.
     * @return ResponseInterface
     */
    public function update(int $task_id = 0): ResponseInterface
    {
        $requestData = $this->validationService->validateAndSanitize($this->request->getJSON(true), 'task_create_rules');

        if (!$requestData->status) {
            return response_fail(message: TranslationKeys::VALIDATION_FAIL, data: $requestData->errors);
        }

        $taskUpdated = $this->taskService->updateTask($task_id, $requestData->data);

        return $taskUpdated
            ? response_success(message: TranslationKeys::UPDATE_SUCCESS)
            : response_fail(message: TranslationKeys::UPDATE_FAIL);
    }

    /**
     * Delete a task for the authenticated user.
     *
     * @param int $task_id The ID of the task to delete.
     * @return ResponseInterface
     */
    public function delete(int $task_id = 0): ResponseInterface
    {
        $task = $this->taskService->getUserTask($task_id);

        if (!$task) {
            return response_fail(message: TranslationKeys::NOT_FOUND);
        }

        return $this->taskService->deleteTask($task_id)
            ? response_success(message: TranslationKeys::DELETE_SUCCESS)
            : response_fail(message: TranslationKeys::DELETE_FAIL);
    }

    /**
     * Assign a task to a friend.
     *
     * @return ResponseInterface
     */
    public function assignTask(): ResponseInterface
    {
        $requestData = $this->validationService->validateAndSanitize($this->request->getJSON(true), 'task_assign_rules');

        if (!$requestData->status) {
            return response_fail(message: TranslationKeys::VALIDATION_FAIL, data: $requestData->errors);
        }

        $assign = $this->taskService->assignTask($requestData->data['task_id'], $requestData->data['friend_id']);

        return $assign
            ? response_success()
            : response_fail();
    }
}
