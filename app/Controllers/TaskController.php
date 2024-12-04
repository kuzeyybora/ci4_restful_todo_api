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
    private $taskModel;
    private $validationService;
    public function __construct()
    {
        $this->validationService = new ValidationService();
        $this->taskModel = model("TaskModel");
    }

    public function index()
    {
        return response_success($this->taskModel->findAll(), TranslationKeys::SUCCESS);
    }

    public function show($id = null)
    {
        return response_success($this->taskModel->find($id), TranslationKeys::SUCCESS);
    }

    public function create()
    {
        $user_id = 1;  // this will take from token via shield
        $requestData = $this->validationService->validateAndSanitize($this->request->getJSON(true), 'task_create_rules');

        if (!$requestData->status) {
            return response_fail(message: TranslationKeys::VALIDATION_FAIL, data: $requestData->errors);
        }
        $taskUserModel = new TaskUserModel();

        $taskData = [
            'title' => $requestData->data['title'],
            'description' => $requestData->data['description'],
            'status' => $requestData->data['status'],
        ];
        $this->taskModel->save($taskData);
        $task_id = $this->taskModel->getInsertID();
        $taskUserData = [
            'task_id' => $task_id,
            'user_id' => $user_id,
        ];
        $taskUserModel->save($taskUserData);

        return response_success($taskData, TranslationKeys::CREATE_SUCCESS);
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
