<?php

namespace App\Services;

use App\Models\FriendshipModel;

class FriendshipService
{
    /**
     * @var FriendshipModel
     */
    private object $friendshipModel;
    private int $userId;
    public function __construct()
    {
        $this->friendshipModel = model("FriendshipModel");
        $this->userId = auth()->id();
    }

    public function sendFriendRequest(int $targetUserId): bool
    {

        if (!auth()->getProvider()->findById($targetUserId)) {

//            return ['status' => false, 'message' => TranslationKeys::NOT_FOUND];
            return false;
        }

        // Kendine istek gönderme kontrolü
        if ($this->userId == $targetUserId) {
//            return ['status' => false, 'message' => TranslationKeys::SELF_REQUEST_DENIED];
            return false;
        }

        $existingRequest = $this->friendshipModel->where([
            'user_id' => $this->userId, 'friend_id' => $targetUserId
        ])->orWhere([
            'user_id' => $targetUserId, 'friend_id' => $this->userId
        ])->first();

        if ($existingRequest) {
//            return ['status' => false, 'message' => TranslationKeys::REQUEST_ALREADY_SENT];
            return false;
        }

        $friendshipRequest = $this->friendshipModel->insert([
            'user_id' => $this->userId,
            'friend_id' => $targetUserId
        ]);

        return (bool)$friendshipRequest;
    }

    public function listIncomingFriendRequests($limit, $page): array
    {
        return $this->friendshipModel->incomingFriendRequest($this->userId, $limit, $page);
    }

    public function acceptOrRejectFriendshipRequest(int $request_id, bool $status): bool
    {
        return $this->friendshipModel->acceptOrRejectRequest($request_id, $this->userId , $status);
    }

    public function listFriendships($limit, $page): ?array
    {
        return $this->friendshipModel->getAcceptedFriends($this->userId, $limit, $page);
    }
}