<?php

namespace App\Interfaces\Services;

interface ITaskService
{
    public function getUserTask(int $task_id = 0): ?object;
    public function getAllUserTasks(int $limit, int $page): ?array;
    public function createTask(array $data): bool;
    public function updateTask(int $taskId, array $data): bool;
    public function assignTask(int $task_id, int $friend_id): bool;
    public function deleteTask(int $task_id): bool;
}
