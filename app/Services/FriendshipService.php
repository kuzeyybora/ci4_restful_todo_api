<?php

namespace App\Services;

use App\Interfaces\Services\IFriendshipService;
use App\Models\FriendshipModel;
use ReflectionException;

class FriendshipService extends BaseService implements IFriendshipService
{
    /**
     * @var FriendshipModel The model used to manage friendship data.
     */
    private object $friendshipModel;

    /**
     * FriendshipService constructor.
     * Initializes the friendship model and sets the current user ID and model name.
     */
    public function __construct()
    {
        $this->friendshipModel = model("FriendshipModel");
        $this->userId = auth()->id();
        $this->modelName = $this->friendshipModel->getModelName();
    }

    /**
     * Sends a friend request to the specified user.
     *
     * @param int $targetUserId The ID of the user to send the friend request to.
     *
     * @return bool Returns true if the request is successfully sent, false otherwise.
     * @throws ReflectionException
     */
    public function sendFriendRequest(int $targetUserId): bool
    {
        if (!auth()->getProvider()->findById($targetUserId)) {
            return false;
        }

        if ($this->userId == $targetUserId) {
            return false;
        }

        $existingRequest = $this->friendshipModel->where([
            'user_id' => $this->userId, 'friend_id' => $targetUserId
        ])->orWhere([
            'user_id' => $targetUserId, 'friend_id' => $this->userId
        ])->first();

        if ($existingRequest) {
            return false;
        }

        $friendshipRequest = $this->friendshipModel->insert([
            'user_id' => $this->userId,
            'friend_id' => $targetUserId
        ]);

        return (bool)$friendshipRequest;
    }

    /**
     * Lists incoming friend requests for the current user.
     *
     * @param int $limit The maximum number of requests to return.
     * @param int $page The page number for pagination.
     *
     * @return array|null Returns an array of incoming friend requests or null if none exist.
     */
    public function listIncomingFriendRequests(int $limit, int $page): ?array
    {
        return $this->friendshipModel->incomingFriendRequest($this->userId, $limit, $page);
    }

    /**
     * Accepts or rejects a friendship request.
     *
     * @param int $request_id The ID of the friendship request.
     * @param bool $status True to accept, false to reject.
     *
     * @return bool Returns true if the operation is successful, false otherwise.
     * @throws ReflectionException
     */
    public function acceptOrRejectFriendshipRequest(int $request_id, bool $status): bool
    {
        return $this->friendshipModel->acceptOrRejectRequest($request_id, $this->userId, $status);
    }

    /**
     * Lists accepted friendships for the current user.
     *
     * @param int $limit The maximum number of friendships to return.
     * @param int $page The page number for pagination.
     *
     * @return array|null Returns an array of friendships or null if none exist.
     */
    public function listFriendships(int $limit, int $page): ?array
    {
        return $this->friendshipModel->getAcceptedFriends($this->userId, $limit, $page);
    }

    /**
     * Lists all friendships in the system.
     *
     * @return array Returns an array of all friendships.
     */
    public function listAllFriendships()
    {
        return $this->friendshipModel->findAll();
    }
}
