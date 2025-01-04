<?php

namespace App\Models;

use CodeIgniter\Model;
use ReflectionException;

class TaskUserModel extends Model
{
    protected $table            = 'task_user';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields    = ['user_id', 'task_id', 'task_owner_id'];

    public function getAllUserTasks(int $user_id, int $limit, int $page): array
    {
        return $this->join('tasks', 'tasks.id = task_user.task_id')
            ->select("tasks.title, tasks.description, tasks.status")
            ->where('task_user.user_id', $user_id)
            ->paginate($limit, 'page', $page);
    }
    public function getUserTaskById(int $user_id, int $task_id): ?object
    {
        return $this->join('tasks', 'tasks.id = task_user.task_id')
            ->select("tasks.title, tasks.description, tasks.status")
            ->where('task_user.user_id', $user_id)
            ->where('task_user.task_id', $task_id)
            ->first();
    }

    /**
     * Assign a task to a friend.
     * Checks if the user has the task and if the task isn't already assigned.
     *
     * @param int $task_id The task ID.
     * @param int $user_id The ID of the user who owns the task.
     * @param int $friend_id The ID of the user to assign the task to.
     *
     * @return bool True if the task was assigned, false if the task cannot be assigned.
     * @throws ReflectionException
     */
    public function assignTask(int $task_id, int $user_id, int $friend_id): bool
    {
        if (empty($this->getUserTaskById($user_id, $task_id)) || $this->where(['task_id' => $task_id, 'user_id' => $friend_id])->first()) {
            return false;
        }

        return (bool) $this->insert([
            'user_id' => $friend_id,
            'task_id' => $task_id,
            'task_owner_id' => $user_id
        ]);
    }
}
