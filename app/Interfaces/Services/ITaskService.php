<?php

namespace App\Interfaces\Services;

interface ITaskService
{
    public function getUserTask(int $task_id = 0): ?object;
    public function getAllUserTasks(int $limit, int $page): ?array;
    public function createTask(object $data): bool;
    public function updateTask(int $taskId, object $data): array;
    public function assignTask(int $task_id, int $friend_id): array|bool;
    public function deleteTask(int $task_id): bool;
}
