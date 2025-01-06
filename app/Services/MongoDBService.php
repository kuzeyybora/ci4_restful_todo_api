<?php

namespace App\Services;

use App\Interfaces\Services\IMongoDBService;
use App\Models\MongoDBModel;

class MongoDBService extends BaseService implements IMongoDBService
{
    private MongoDBModel $mongoModel;
    public string $modelName;
    public function __construct()
    {
        $this->mongoModel = new MongoDBModel();
        $this->modelName = $this->mongoModel->getModelName();
    }

    public function getAllLogs(int $limit = 10, int $page = 1, array $filters = []): ?array
    {
        return $this->mongoModel->find();
    }

    public function getLog(int $id): ?array
    {
        return $this->mongoModel->findOneById($id);
    }

    public function logToMongoDB($service, $model, $action , $details, $userId): bool
    {
        $data = [
            'service'     => $service,
            'model'     => $model,
            'action'    => $action,
            'details'   => $details,
            'user_id'   => $userId,
            'created_at'=> date('Y-m-d H:i:s')
        ];

        $log = $this->mongoModel->insert($data);

        return (bool)$log;

    }
}