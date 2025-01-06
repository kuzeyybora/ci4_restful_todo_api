<?php


namespace App\Services;

use App\Interfaces\Services\IAdminService;
use CodeIgniter\Events\Events;

class AdminService extends BaseService implements IAdminService {
    public function __construct()
    {
        $this->userId = auth()->id();
    }
    public function listUsers(): ?array
    {
        $this->triggerAuditEvent(__FUNCTION__, "Auth" ,$this->getServiceName());
        return auth()->getProvider()->findAll();
    }
    public function listLogs(): ?array
    {
        /** @var MongoDBService $model */
        $model = service('mongoDBService');

        $this->triggerAuditEvent(__FUNCTION__, $model->modelName ,$this->getServiceName());

        return $model->getAllLogs();
    }

    public function listFriendships(): ?array
    {
        /** @var FriendshipService $model */
        $model = service('friendshipService');

        $this->triggerAuditEvent(__FUNCTION__, $model->modelName, $this->getServiceName());

        return $model->listAllFriendships();
    }

    public function listTasks(): ?array
    {
        /** @var TaskService $model  */
        $model = service('taskService');

        $this->triggerAuditEvent(__FUNCTION__, $model->modelName, $this->getServiceName());

        return $model->getAllTasks();
    }

    public function listQueues(): ?array
    {
        $model = service('redisService');

        $this->triggerAuditEvent(__FUNCTION__, "Redis",  $this->getServiceName());

        return $model->getAllQueues();
    }

    public function listTaskUsers(): ?array
    {
        /** @var TaskService $model  */
        $model = service('taskService');

        $this->triggerAuditEvent(__FUNCTION__, $model->modelName, $this->getServiceName());

        return $model->getAllTaskUsers();
    }

    public function listTranslations(string $locale): ?array
    {
        /** @var TranslationService $model  */
        $model = service('translationService');

        $this->triggerAuditEvent(__FUNCTION__, $model->modelName, $this->getServiceName());

        return $model->fetchTranslationsFromDatabase($locale);
    }
    private function triggerAuditEvent(string $action, string $model, string $service, $details = null): void
    {
        $log = [
            'serviceName' => $service,
            'modelName' => $model,
            'action' => $action,
            'details' => $details,
            'user_id'    => $this->userId,
        ];

        Events::trigger('auditLog', $log);
    }
}