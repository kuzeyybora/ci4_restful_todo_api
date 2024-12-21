<?php

namespace App\Controllers;

use App\Constants\TranslationKeys;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class FriendshipController extends BaseController
{
    private $friendshipModel;

    public function __construct()
    {
        $this->friendshipModel = model("FriendshipModel");
    }
    public function sendRequest(int $targetUserId): ResponseInterface
    {
        $userId = auth()->getUser()->id;

        if (!auth()->getProvider()->findById($targetUserId)) {
            return response_fail(TranslationKeys::NOT_FOUND);
        }
        if ($userId == $targetUserId) {
            return response_fail(TranslationKeys::SELF_REQUEST_DENIED);
        }

        $existingRequest = $this->friendshipModel->where([
            'user_id' => $userId, 'friend_id' => $targetUserId
        ])->orWhere([
            'user_id' => $targetUserId, 'friend_id' => $userId
        ])->first();

        if ($existingRequest) {
            return response_fail(TranslationKeys::REQUEST_ALREADY_SENT);
        }

        $friendshipRequest = $this->friendshipModel->insert([
           'user_id' => auth()->getUser()->id,
           'friend_id' => $targetUserId
        ]);

        return $friendshipRequest
            ? response_success(message: TranslationKeys::REQUEST_SUCCESS)
            : response_fail(TranslationKeys::REQUEST_FAIL);
    }
    public function listIncomingRequests(): ResponseInterface
    {
        $userId = auth()->getUser()->id;

        $incomingRequests = $this->friendshipModel->select('id, user_id, friend_id')->where([
            'friend_id' => $userId,
            'status' => 'pending'
        ])->findAll();

        return $incomingRequests
            ? response_success($incomingRequests)
            : response_fail(TranslationKeys::NOT_FOUND);

    }
    public function acceptFriendship(int $requesterId)
    {
        return "Function Name : ". __FUNCTION__;
    }
    public function rejectFriendship()
    {
        return "Function Name : ". __FUNCTION__;

    }
    public function listFriendships()
    {
        return "Function Name : ". __FUNCTION__;

    }
}
