<?php

namespace App\Controllers;

use App\Constants\TranslationKeys;
use App\Services\FriendshipService;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Class FriendshipController
 *
 * Handles friendship-related actions such as sending requests,
 * listing requests, accepting or rejecting requests, and listing friendships.
 */
class FriendshipController extends BaseController
{
    /**
     * @var FriendshipService $friendshipService Service for handling friendship operations
     */
    private object $friendshipService;

    /**
     * FriendshipController constructor.
     * Initializes the FriendshipService instance.
     */
    public function __construct()
    {
        $this->friendshipService = service('friendshipService');
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
     */
    public function listIncomingRequests(): ResponseInterface
    {
        return ($incomingRequests = $this->friendshipService->listIncomingFriendRequests())
            ? response_success($incomingRequests)
            : response_fail(TranslationKeys::NOT_FOUND);
    }

    /**
     * Accepts a friendship request by ID.
     *
     * @param int $request_id ID of the friendship request to accept
     * @return ResponseInterface Response indicating success or failure
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
     */
    public function listFriendships(): ResponseInterface
    {
        return ($friendships = $this->friendshipService->listFriendships())
            ? response_success($friendships)
            : response_fail();
    }
}
