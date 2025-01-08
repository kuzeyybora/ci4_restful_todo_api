<?php

namespace App\Controllers;

use App\Constants\TranslationKeys;
use App\Controllers\BaseController;
use App\Services\RedisService;
use App\Services\ValidationService;
use CodeIgniter\HTTP\ResponseInterface;

class QueueController extends BaseController
{
    /** @var RedisService $redisService  */
    public object $redisService;

    /** @var ValidationService $validationService */
    public object $validationService;
    public function __construct()
    {
        $this->redisService = service('RedisService');
        $this->validationService = service('ValidationService');
    }

    /**
     * Retrieves all queues from the Redis service and returns a success response.
     *
     * @return ResponseInterface A response containing the list of all queues.
     */
    public function listQueues(): ResponseInterface
    {
        return response_success($this->redisService->getAllQueues());
    }

    /**
     * Adds a new email queue to the Redis service after validating and sanitizing the request data.
     *
     * @return ResponseInterface A response indicating the success or failure of adding the queue.
     */
    public function addQueue(): ResponseInterface
    {
        $requestData = $this->validationService->validateAndSanitize($this->request->getJSON(true), 'queue_add_rules');

        if (!$requestData->status) {
            return response_fail(message: TranslationKeys::VALIDATION_FAIL, data: $requestData->errors);
        }
        $queueStatus = $this->redisService->AddEmailQueue($requestData->data['email'], $requestData->data['subject'], $requestData->data['message']);

        return $queueStatus
            ? response_success(message: TranslationKeys::EMAIL_QUEUED)
            : response_fail();
    }
}
