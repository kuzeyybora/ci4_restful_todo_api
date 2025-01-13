<?php

namespace App\Controllers;

use App\Constants\TranslationKeys;
use App\Controllers\BaseController;
use App\Exception\ValidationException;
use App\Services\RedisService;
use App\Services\ValidationService;
use CodeIgniter\HTTP\ResponseInterface;

class QueueController extends BaseController
{
    /** @var RedisService $redisService  */
    private object $redisService;

    /** @var ValidationService $validationService */
    private object $validationService;
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
     * @throws ValidationException
     */
    public function addQueue(): ResponseInterface
    {
        $sanitizedData = $this->validationService->validateAndSanitize($this->request->getJSON(true), ['queue_add_rules']);

        $queueStatus = $this->redisService->AddEmailQueue($sanitizedData->email, $sanitizedData->subject, $sanitizedData->message);

        return $queueStatus
            ? response_success(message: TranslationKeys::EMAIL_QUEUED)
            : response_fail();
    }
}
