<?php

namespace App\Services;

use App\Interfaces\Services\IMongoDBService;
use App\Models\MongoDBModel;

class MongoDBService extends BaseService implements IMongoDBService
{
    /**
     * @var MongoDBModel The model used for MongoDB interactions.
     */
    private MongoDBModel $mongoModel;

    /**
     * @var string The name of the model used by the service.
     */
    public string $modelName;

    /**
     * MongoDBService constructor.
     * Initializes the MongoDB model and sets the model name.
     */
    public function __construct()
    {
        $this->mongoModel = new MongoDBModel();
        $this->modelName = $this->mongoModel->getModelName();
    }

    /**
     * Retrieves all logs from the MongoDB collection with optional pagination and filters.
     *
     * @param int $limit The maximum number of logs to retrieve.
     * @param int $page The page number for pagination.
     * @param array $filters Optional filters to apply to the query.
     *
     * @return array|null An array of logs or null if no logs are found.
     */
    public function getAllLogs(int $limit = 10, int $page = 1, array $filters = []): ?array
    {
        return $this->mongoModel->find();
    }

    /**
     * Retrieves a specific log by its ID.
     *
     * @param int $id The ID of the log to retrieve.
     *
     * @return array|null An array representing the log or null if not found.
     */
    public function getLog(int $id): ?array
    {
        return $this->mongoModel->findOneById($id);
    }

    /**
     * Logs an action to the MongoDB collection.
     *
     * @param string $service The name of the service performing the action.
     * @param string $model The name of the model involved in the action.
     * @param string $action The action being logged.
     * @param mixed $details Additional details about the action.
     * @param int $userId The ID of the user performing the action.
     *
     * @return bool Returns true if the log is successfully created, false otherwise.
     */
    public function logToMongoDB($service, $model, $action, $details, $userId): bool
    {
        $data = [
            'service'     => $service,
            'model'       => $model,
            'action'      => $action,
            'details'     => $details,
            'user_id'     => $userId,
            'created_at'  => date('Y-m-d H:i:s')
        ];

        $log = $this->mongoModel->insert($data);

        return (bool)$log;
    }
}
