<?php

namespace App\Controllers;

use App\Constants\TranslationKeys;
use App\Controllers\BaseController;
use App\Models\TaskModel;
use App\Models\TaskUserModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Services\ValidationService;

class TaskController extends BaseController
{
    /**
     * @var TaskModel
     */
    private $taskModel;

    /**
     * @var TaskUserModel
     */
    private $taskUserModel;

    private $validationService;
    public function __construct()
    {
        $this->validationService = new ValidationService();
        $this->taskModel = model("TaskModel");
        $this->taskUserModel = model("TaskUserModel");
    }

    public function index()
    {
        $query = $this->taskUserModel->getUserTasks(auth()->id());

        return $query
            ? response_success($query, TranslationKeys::SUCCESS)
            : response_fail(message: TranslationKeys::NOT_FOUND);
    }

    public function show(int $task_id = 0)
    {
        $query = $this->taskUserModel->getUserTask(auth()->id(), $task_id);

        return $query
            ? response_success($query, TranslationKeys::SUCCESS)
            : response_fail(message: TranslationKeys::NOT_FOUND);
    }

    public function create()
    {
        $requestData = $this->validationService->validateAndSanitize($this->request->getJSON(true), 'task_create_rules');

        if (!$requestData->status) {
            return response_fail(message: TranslationKeys::VALIDATION_FAIL, data: $requestData->errors);
        }

        $task_status = $this->taskModel->save([
            'title' => $requestData->data['title'],
            'description' => $requestData->data['description'],
            'status' => $requestData->data['status'],
        ]);

        $task_id = $this->taskModel->getInsertID();

        $taskUser_status = $this->taskUserModel->save([
            'task_id' => $task_id,
            'user_id' => auth()->id()
        ]);

        if ($task_status && $taskUser_status) {
            return response_success(message: TranslationKeys::CREATE_SUCCESS);
        } else {
            return response_fail(message: TranslationKeys::CREATE_FAIL);
        }
    }

    public function update(int $task_id = 0)
    {
        $requestData = $this->validationService->validateAndSanitize($this->request->getJSON(true), 'task_create_rules');

        if (!$requestData->status) {
            return response_fail(message: TranslationKeys::VALIDATION_FAIL, data: $requestData->errors);
        }
        $task = $this->taskUserModel->getUserTask(auth()->id(), $task_id);

        if (!$task) {
            return response_fail(message: TranslationKeys::NOT_FOUND);
        }

        $updateData = $this->taskModel->update($task_id, [
            'title' => $requestData->data['title'] ?? $task->title,
            'description' => $requestData->data['description'] ?? $task->description,
            'status' => $requestData->data['status'] ?? $task->status
        ]);

        return $updateData
            ? response_success(message: TranslationKeys::UPDATE_SUCCESS)
            : response_fail(message: TranslationKeys::UPDATE_FAIL);
    }

    public function delete(int $task_id = 0)
    {
        $requestData = $this->validationService->validateAndSanitize($this->request->getJSON(true), 'task_create_rules');

        if (!$requestData->status) {
            return response_fail(message: TranslationKeys::VALIDATION_FAIL, data: $requestData->errors);
        }
        $task = $this->taskUserModel->getUserTask(auth()->id(), $task_id);

        if (!$task) {
            return response_fail(message: TranslationKeys::NOT_FOUND);
        }

        return $this->taskModel->delete($task_id)
            ? response_success(message: TranslationKeys::DELETE_SUCCESS)
            : response_fail(message: TranslationKeys::DELETE_FAIL);
    }
}
