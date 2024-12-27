<?php
namespace App\Services;

use App\Models\FriendshipModel;
use App\Models\TaskModel;
use App\Models\TaskUserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class TaskService
{
    /**
     * @var TaskModel
     */
    protected $taskModel;

    /**
     * @var TaskUserModel
     */
    protected $taskUserModel;

    /**
     * @var FriendshipModel
     */
    protected $friendshipModel;
    public function __construct()
    {
        $this->taskModel = model('TaskModel');
        $this->taskUserModel = model('TaskUserModel');
        $this->friendshipModel = model('FriendshipModel');
    }
    public function getUserTask(int $task_id = 0): ?object
    {
        return $this->taskUserModel->getUserTaskById(auth()->id(), $task_id);
    }

    public function getAllUserTasks(): ?array
    {
        return $this->taskUserModel->getAllUserTasks(auth()->id());
    }
    public function createTask(array $data): bool
    {
        $this->taskModel->db->transStart();

        try {
            $taskStatus = $this->taskModel->save([
                'title' => $data['title'],
                'description' => $data['description'],
                'status' => $data['status'],
            ]);

            $taskId = $this->taskModel->getInsertID();

            $taskUserStatus = $this->taskUserModel->save([
                'user_id' => auth()->id(),
                'task_id' => $taskId,
                'task_owner_id' => auth()->id(),
            ]);

            if ($taskStatus && $taskUserStatus) {
                $this->taskModel->db->transComplete();
                return true;
            } else {
                $this->taskModel->db->transRollback();
                return false;
            }

        } catch (DatabaseException $e) {
            $this->taskModel->db->transRollback();
            return false;
        }
    }
    public function updateTask(int $taskId, array $data): bool
    {
        $task = $this->taskUserModel->getUserTaskById(auth()->id(), $taskId);

        if (!$task) {
            return false;
        }

        return $this->taskModel->update($taskId, [
            'title' => $data['title'] ?? $task->title,
            'description' => $data['description'] ?? $task->description,
            'status' => $data['status'] ?? $task->status
        ]);
    }
    public function assignTask(int $task_id, int $friend_id): bool
    {
        if (!$this->friendshipModel->checkFriendship(auth()->id(), $friend_id)) {
            return false;
        }
        if (!$this->taskModel->find($task_id)) {
            return false;
        }
        return $this->taskUserModel->assignTask($task_id, auth()->id(), $friend_id);
    }
    public function deleteTask($task_id): bool
    {
        return $this->taskModel->delete($task_id);
    }
}
