<?php
namespace App\Services;

use App\Constants\TranslationKeys;
use App\Interfaces\Services\ITaskService;
use App\Models\FriendshipModel;
use App\Models\TaskModel;
use App\Models\TaskUserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use ReflectionException;

class TaskService extends BaseService implements ITaskService
{
    /** @var TaskModel */
    protected object $taskModel;

    /** @var TaskUserModel */
    protected object $taskUserModel;

    /** @var FriendshipModel */
    protected object $friendshipModel;
    public function __construct()
    {
        $this->taskModel = model('TaskModel');
        $this->taskUserModel = model('TaskUserModel');
        $this->friendshipModel = model('FriendshipModel');
        $this->userId = auth()->id();
        $this->modelName = $this->taskModel->getModelName();
    }

    /**
     * Get a specific task for the logged-in user.
     *
     * @param int $task_id The ID of the task.
     * @return object|null The task object or null if not found.
     */
    public function getUserTask(int $task_id = 0): ?object
    {
        return $this->taskUserModel->getUserTaskById($this->userId, $task_id);
    }

    /**
     * Get all tasks for the logged-in user, with pagination support.
     *
     * @param int $limit The number of tasks per page.
     * @param int $page The current page number.
     * @return array|null The list of tasks or null if no tasks are found.
     */
    public function getAllUserTasks(int $limit = 10, int $page = 1): ?array
    {
        return $this->taskUserModel->getAllUserTasks($this->userId, $limit, $page);
    }


    /**
     * Create a new task and assign it to the logged-in user.
     *
     * @param object $data The task data (title, description, status).
     * @return bool True if the task was created and assigned successfully, false otherwise.
     * @throws ReflectionException
     */
    public function createTask(object $data): bool
    {
        $this->taskModel->db->transStart();

        try {
            $taskStatus = $this->taskModel->save([
                'title' => $data->title,
                'description' => $data->description,
                'status' => $data->status,
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

        } catch (DatabaseException) {
            $this->taskModel->db->transRollback();
            return false;
        }
    }

    /**
     * Update an existing task for the logged-in user.
     *
     * @param int $taskId The ID of the task to update.
     * @param object $data The new task data (title, description, status).
     * @return string[] True if the task was updated successfully, false otherwise.
     * @throws ReflectionException
     */
    public function updateTask(int $taskId, object $data): array
    {
        $task = $this->taskUserModel->getUserTaskById($this->userId, $taskId);

        if (!$task) {
            return ['status' => false, 'message' => TranslationKeys::NOT_FOUND];
        }

        if ($task == $data) {
            return ['status' => false, 'message' => TranslationKeys::UPDATE_EXISTS];
        }

        $updateTask = $this->taskModel->update($taskId, $data);
        return $updateTask
            ? ['status' => true, 'message' => TranslationKeys::UPDATE_SUCCESS]
            : ['status' => false, 'message' => TranslationKeys::UPDATE_FAIL];
    }

    /**
     * Assign an existing task to a friend.
     *
     * @param int $task_id The task ID.
     * @param int $friend_id The ID of the friend to assign the task to.
     * @return array|bool True if the task was successfully assigned, false otherwise.
     * @throws ReflectionException
     */
    public function assignTask(int $task_id, int $friend_id): array|bool
    {
        if (!$this->friendshipModel->checkFriendship($this->userId, $friend_id)) {
            return ['status' => false, 'message' => TranslationKeys::FRIEND_NOT_FOUND];
        }

        if (!$this->taskModel->find($task_id)) {
            return ['status' => false, 'message' => TranslationKeys::NOT_FOUND];
        }

        return $this->taskUserModel->assignTask($task_id, $this->userId, $friend_id)
            ? ['status' => true, 'message' => TranslationKeys::TASK_ASSIGN_SUCCESFUL]
            : ['status' => false, 'message' => TranslationKeys::TASK_ASSIGN_UNSUCCESFUL];
    }

    /**
     * Delete a task for the logged-in user.
     *
     * @param int $task_id The ID of the task to delete.
     * @return bool True if the task was deleted successfully, false otherwise.
     */
    public function deleteTask(int $task_id): bool
    {
        return $this->taskModel->delete($task_id);
    }

    /**
     * Get all tasks from the database.
     *
     * @param int $limit The number of tasks per page.
     * @param int $page The current page number.
     * @return array|null The list of all tasks or null if no tasks are found.
     */
    public function getAllTasks(int $limit = 10, int $page = 1): ?array
    {
        return $this->taskModel->paginate($limit, $page);
    }

    /**
     * Get all task-user relationships from the database.
     *
     * @param int $limit The number of relationships per page.
     * @param int $page The current page number.
     * @return array|null The list of all task-user relationships or null if none are found.
     */
    public function getAllTaskUsers(int $limit = 10, int $page = 1): ?array
    {
        return $this->taskUserModel->paginate($limit, $page);
    }
}
