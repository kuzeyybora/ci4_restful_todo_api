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
    private readonly int $userId;
    public function __construct()
    {
        $this->taskModel = model('TaskModel');
        $this->taskUserModel = model('TaskUserModel');
        $this->friendshipModel = model('FriendshipModel');
        $this->userId = auth()->id();
    }
    public function getUserTask(int $task_id = 0): ?object
    {
        return $this->taskUserModel->getUserTaskById($this->userId, $task_id);
    }

    public function getAllUserTasks($limit, $page): ?array
    {
        return $this->taskUserModel->getAllUserTasks($this->userId, $limit, $page);
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
                'user_id' => $this->userId,
                'task_id' => $taskId,
                'task_owner_id' => $this->userId,
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
        $task = $this->taskUserModel->getUserTaskById($this->userId, $taskId);

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
        if (!$this->friendshipModel->checkFriendship($this->userId, $friend_id)) {
            return false;
        }
        if (!$this->taskModel->find($task_id)) {
            return false;
        }
        return $this->taskUserModel->assignTask($task_id, $this->userId, $friend_id);
    }
    public function deleteTask($task_id): bool
    {
        return $this->taskModel->delete($task_id);
    }
}
