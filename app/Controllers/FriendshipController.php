<?php

namespace App\Controllers;

use App\Constants\TranslationKeys;
use App\Controllers\BaseController;
use App\Models\FriendshipModel;
use App\Services\ValidationService;
use CodeIgniter\HTTP\ResponseInterface;

class FriendshipController extends BaseController
{
    /**
     * @var FriendshipModel
     */
    private $friendshipModel;

    private $validationService;

    public function __construct()
    {
        $this->friendshipModel = model("FriendshipModel");
        $this->validationService = new ValidationService();
    }
    public function sendRequest(int $targetUserId): ResponseInterface
    {
        if (!auth()->getProvider()->findById($targetUserId)) {
            return response_fail(TranslationKeys::NOT_FOUND);
        }
        if (auth()->getUser()->id == $targetUserId) {
            return response_fail(TranslationKeys::SELF_REQUEST_DENIED);
        }

        $existingRequest = $this->friendshipModel->where([
            'user_id' => auth()->getUser()->id, 'friend_id' => $targetUserId
        ])->orWhere([
            'user_id' => $targetUserId, 'friend_id' => auth()->getUser()->id
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
        $incomingRequests = $this->friendshipModel->incomingFriendRequest(auth()->getUser()->id);

        return $incomingRequests
            ? response_success($incomingRequests)
            : response_fail(TranslationKeys::NOT_FOUND);

    }
    public function acceptFriendship(): ResponseInterface
    {
        $requestData = $this->validationService->validateAndSanitize($this->request->getJSON(true), 'friendship_request');

        if (!$requestData->status) {
            return response_fail(message: TranslationKeys::VALIDATION_FAIL, data: $requestData->errors);
        }

        return $this->friendshipModel->acceptOrRejectRequest($requestData->data['friendship_id'], auth()->getUser()->id,true)
            ? response_success()
            : response_fail();
    }
    public function rejectFriendship(): ResponseInterface
    {
        $requestData = $this->validationService->validateAndSanitize($this->request->getJSON(true), 'friendship_request');

        if (!$requestData->status) {
            return response_fail(message: TranslationKeys::VALIDATION_FAIL, data: $requestData->errors);
        }

        return $this->friendshipModel->acceptOrRejectRequest($requestData->data['friendship_id'], auth()->getUser()->id,false)
            ? response_success()
            : response_fail();
    }
    public function listFriendships(): ResponseInterface
    {
        $friendships = $this->friendshipModel->getAcceptedFriends(auth()->getUser()->id);
        // can be simplified
        return $friendships
            ? response_success($friendships)
            : response_fail();

    }
}
