<?php

namespace App\Services;

use App\Interfaces\Services\IAdminService;
use CodeIgniter\Events\Events;

class AdminService extends BaseService implements IAdminService
{
    public function __construct()
    {
        $this->userId = auth()->id();
    }

    /**
     * Retrieves a list of all users.
     *
     * @return array|null Returns an array of users or null if none exist.
     */
    public function listUsers(): ?array
    {
        $this->triggerAuditEvent(__FUNCTION__, "Auth", $this->getServiceName());
        return auth()->getProvider()->findAll();
    }

    /**
     * Retrieves a list of all logs.
     *
     * @return array|null Returns an array of logs or null if none exist.
     */
    public function listLogs(): ?array
    {
        /** @var MongoDBService $model */
        $model = service('mongoDBService');

        $this->triggerAuditEvent(__FUNCTION__, $model->modelName, $this->getServiceName());

        return $model->getAllLogs();
    }

    /**
     * Retrieves a list of all friendships.
     *
     * @return array|null Returns an array of friendships or null if none exist.
     */
    public function listFriendships(): ?array
    {
        /** @var FriendshipService $model */
        $model = service('friendshipService');

        $this->triggerAuditEvent(__FUNCTION__, $model->modelName, $this->getServiceName());

        return $model->listAllFriendships();
    }

    /**
     * Retrieves a list of all tasks.
     *
     * @return array|null Returns an array of tasks or null if none exist.
     */
    public function listTasks(): ?array
    {
        /** @var TaskService $model */
        $model = service('taskService');

        $this->triggerAuditEvent(__FUNCTION__, $model->modelName, $this->getServiceName());

        return $model->getAllTasks();
    }

    /**
     * Retrieves a list of all queues.
     *
     * @return array|null Returns an array of queues or null if none exist.
     */
    public function listQueues(): ?array
    {
        $model = service('redisService');

        $this->triggerAuditEvent(__FUNCTION__, "Redis", $this->getServiceName());

        return $model->getAllQueues();
    }

    /**
     * Retrieves a list of all users assigned to tasks.
     *
     * @return array|null Returns an array of task users or null if none exist.
     */
    public function listTaskUsers(): ?array
    {
        /** @var TaskService $model */
        $model = service('taskService');

        $this->triggerAuditEvent(__FUNCTION__, $model->modelName, $this->getServiceName());

        return $model->getAllTaskUsers();
    }

    /**
     * Retrieves translations for a given locale from the database.
     *
     * @param string $locale The locale for which translations should be fetched.
     * @return array|null Returns an array of translations or null if none exist.
     */
    public function listTranslations(string $locale): ?array
    {
        /** @var TranslationService $model */
        $model = service('translationService');

        $this->triggerAuditEvent(__FUNCTION__, $model->modelName, $this->getServiceName());

        return $model->fetchTranslationsFromDatabase($locale);
    }

    /**
     * Triggers an audit event to log actions performed by the service.
     *
     * @param string $action The name of the action being performed.
     * @param string $model The name of the model related to the action.
     * @param string $service The name of the service performing the action.
     * @param mixed|null $details Additional details related to the action.
     */
    private function triggerAuditEvent(string $action, string $model, string $service, $details = null): void
    {
        $log = [
            'serviceName' => $service,
            'modelName' => $model,
            'action' => $action,
            'details' => $details,
            'user_id' => $this->userId,
        ];

        Events::trigger('auditLog', $log);
    }
}
