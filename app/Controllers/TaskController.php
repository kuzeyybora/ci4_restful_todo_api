<?php

namespace App\Controllers;

use App\Constants\TranslationKeys;
use App\Controllers\BaseController;
use App\Models\FriendshipModel;
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

    /**
     * @var FriendshipModel
     */
    private $friendshipModel;

    private $validationService;
    public function __construct()
    {
        $this->validationService = new ValidationService();
        $this->taskModel = model("TaskModel");
        $this->taskUserModel = model("TaskUserModel");
        $this->friendshipModel = model("FriendshipModel");
    }

    public function index(): ResponseInterface
    {
        $query = $this->taskUserModel->getUserTasks(auth()->id());

        return $query
            ? response_success($query, TranslationKeys::SUCCESS)
            : response_fail(message: TranslationKeys::NOT_FOUND);
    }

    public function show(int $task_id = 0): ResponseInterface
    {
        $query = $this->taskUserModel->getUserTask(auth()->id(), $task_id);

        return $query
            ? response_success($query, TranslationKeys::SUCCESS)
            : response_fail(message: TranslationKeys::NOT_FOUND);
    }

    public function create(): ResponseInterface
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
            'user_id' => auth()->id(),
            'task_owner_id' => auth()->id()
        ]);

        if ($task_status && $taskUser_status) {
            return response_success(message: TranslationKeys::CREATE_SUCCESS);
        } else {
            return response_fail(message: TranslationKeys::CREATE_FAIL);
        }
    }

    public function update(int $task_id = 0): ResponseInterface
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

    public function delete(int $task_id = 0): ResponseInterface
    {
        $task = $this->taskUserModel->getUserTask(auth()->id(), $task_id);

        if (!$task) {
            return response_fail(message: TranslationKeys::NOT_FOUND);
        }

        return $this->taskModel->delete($task_id)
            ? response_success(message: TranslationKeys::DELETE_SUCCESS)
            : response_fail(message: TranslationKeys::DELETE_FAIL);
    }
    public function assignTask(): ResponseInterface
    {
        $requestData = $this->validationService->validateAndSanitize($this->request->getJSON(true), 'task_assign_rules');

        if (!$requestData->status) {
            return response_fail(message: TranslationKeys::VALIDATION_FAIL, data: $requestData->errors);
        }
        $checkFriendship = $this->friendshipModel->checkFriendship(auth()->getUser()->id, $requestData->data['friend_id']);
        $checkTask = $this->taskModel->find($requestData->data['task_id']);
        if (!$checkFriendship || !$checkTask)
        {
            return response_fail(message: TranslationKeys::NOT_FOUND);
        }
        $assign = $this->taskUserModel->assignTask($requestData->data['task_id'], auth()->getUser()->id, $requestData->data['friend_id']);

        return $assign
            ? response_success()
            : response_fail();
    }
}
