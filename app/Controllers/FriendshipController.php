<?php

namespace App\Controllers;

use App\Constants\TranslationKeys;
use App\Exception\ValidationException;
use App\Services\FriendshipService;
use App\Services\ValidationService;
use CodeIgniter\HTTP\ResponseInterface;
use ReflectionException;

/**
 * Class FriendshipController
 *
 * Handles friendship-related actions such as sending requests,
 * listing requests, accepting or rejecting requests, and listing friendships.
 */
class FriendshipController extends BaseController
{
    /** @var FriendshipService $friendshipService */
    private object $friendshipService;

    /** @var ValidationService $validationService */
    private object $validationService;

    public function __construct()
    {
        $this->friendshipService = service('friendshipService');
        $this->validationService = service('validationService');
    }

    /**
     * Sends a friendship request to the specified user.
     *
     * @param int $targetUserId ID of the user to send the friendship request to
     * @return ResponseInterface Response indicating success or failure
     */
    public function sendRequest(int $targetUserId): ResponseInterface
    {
        return ($friendshipRequest = $this->friendshipService->sendFriendRequest($targetUserId))
            ? response_success(message: TranslationKeys::REQUEST_SUCCESS)
            : response_fail(TranslationKeys::REQUEST_FAIL);
    }

    /**
     * Lists all incoming friendship requests for the authenticated user.
     *
     * @return ResponseInterface Response containing a list of incoming requests or a failure message
     * @throws ValidationException
     */
    public function listIncomingRequests(): ResponseInterface
    {
        $sanitizedData = $this->validationService->validateAndSanitize($this->request->getJSON(true), ['pagination_rule']);

        return ($incomingRequests = $this->friendshipService->listIncomingFriendRequests($sanitizedData->limit, $sanitizedData->page))
            ? response_success($incomingRequests)
            : response_fail(TranslationKeys::NOT_FOUND);
    }

    /**
     * Accepts a friendship request by ID.
     *
     * @param int $request_id ID of the friendship request to accept
     * @return ResponseInterface Response indicating success or failure
     * @throws ReflectionException
     */
    public function acceptFriendship(int $request_id): ResponseInterface
    {
        return $this->friendshipService->acceptOrRejectFriendshipRequest($request_id, true)
            ? response_success()
            : response_fail();
    }

    /**
     * Rejects a friendship request by ID.
     *
     * @param int $request_id ID of the friendship request to reject
     * @return ResponseInterface Response indicating success or failure
     * @throws ReflectionException
     */
    public function rejectFriendship(int $request_id): ResponseInterface
    {
        return $this->friendshipService->acceptOrRejectFriendshipRequest($request_id, false)
            ? response_success()
            : response_fail();
    }

    /**
     * Lists all friendships for the authenticated user.
     *
     * @return ResponseInterface Response containing a list of friendships or a failure message
     * @throws ValidationException
     */
    public function listFriendships(): ResponseInterface
    {
        $sanitizedData = $this->validationService->validateAndSanitize($this->request->getJSON(true), ['pagination_rule']);

        return ($friendships = $this->friendshipService->listFriendships($sanitizedData->limit, $sanitizedData->page))
            ? response_success($friendships)
            : response_fail();
    }
}
