<?php

namespace App\Controllers;

use App\Constants\TranslationKeys;
use App\Exception\ValidationException;
use App\Services\TaskService;
use App\Services\ValidationService;
use CodeIgniter\HTTP\ResponseInterface;
use ReflectionException;

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
     * Retrieves tasks for the authenticated user with pagination.
     * Validates and sanitizes input data.
     *
     * @return ResponseInterface
     * @throws ValidationException
     */
    public function index(): ResponseInterface
    {
        $sanitizedData = $this->validationService->validateAndSanitize($this->request->getJSON(true), ['pagination_rule']);

        $tasks = $this->taskService->getAllUserTasks($sanitizedData->limit, $sanitizedData->page);

        return $tasks
            ? response_success($tasks, TranslationKeys::SUCCESS)
            : response_fail(message: TranslationKeys::NOT_FOUND);
    }


    /**
     * Get a specific task for the authenticated user.
     *
     * @param int $id The ID of the task to retrieve.
     * @return ResponseInterface
     */
    public function show(int $id): ResponseInterface
    {
        $task = $this->taskService->getUserTask($id);

        return $task
            ? response_success($task)
            : response_fail(message: TranslationKeys::NOT_FOUND);
    }

    /**
     * Create a new task for the authenticated user.
     *
     * @return ResponseInterface
     * @throws ValidationException|ReflectionException
     */
    public function create(): ResponseInterface
    {
        $sanitizedData = $this->validationService->validateAndSanitize($this->request->getJSON(true), ['task_create_rules']);

        return $this->taskService->createTask($sanitizedData)
            ? response_success(message: TranslationKeys::CREATE_SUCCESS)
            : response_fail(TranslationKeys::CREATE_FAIL);
    }

    /**
     * Update an existing task for the authenticated user.
     *
     * @param int $task_id The ID of the task to update.
     * @return ResponseInterface
     * @throws ValidationException|ReflectionException
     */
    public function update(int $task_id = 0): ResponseInterface
    {
        $sanitizedData = $this->validationService->validateAndSanitize($this->request->getJSON(true), ['task_create_rules']);

        $taskUpdated = $this->taskService->updateTask($task_id, $sanitizedData);

        return $taskUpdated['status']
            ? response_success(message: $taskUpdated['message'])
            : response_fail($taskUpdated['message']);
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
     * @throws ReflectionException|ValidationException
     */
    public function assignTask(): ResponseInterface
    {
        $sanitizedData = $this->validationService->validateAndSanitize($this->request->getJSON(true), ['task_assign_rules']);

        $assign = $this->taskService->assignTask($sanitizedData->task_id, $sanitizedData->friend_id);

        return $assign['status']
            ? response_success(message: $assign['message'])
            : response_fail($assign['message']);
    }
}
