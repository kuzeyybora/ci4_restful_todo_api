<?php

namespace App\Models;

use App\Entities\FriendshipEntity;
use CodeIgniter\Model;
use ReflectionException;

class FriendshipModel extends BaseModel
{
    protected $table            = 'friendships';
    protected $primaryKey       = 'id';
    protected $returnType       = FriendshipEntity::class;
    protected $allowedFields    = ['user_id', 'friend_id', 'status'];

    /**
     * Retrieves the accepted friends of a specific user with pagination.
     *
     * @param int $user_id The ID of the user whose friends are being retrieved.
     * @param int $limit The number of records to fetch per page (default is 10).
     * @param int $page The page number for pagination (default is 1).
     * @return array|null A list of accepted friendships, or null if no results are found.
     */
    public function getAcceptedFriends (int $user_id, int $limit = 10, int $page = 1): ?array
    {
        return $this->select('user_id, friend_id')
            ->where('status', 'accepted')
            ->groupStart()
            ->where('user_id', $user_id)
            ->orWhere('friend_id', $user_id)
            ->groupEnd()
            ->paginate($limit, 'page', $page);
    }


    /**
     * Retrieves incoming friend requests for a specific user with pagination.
     *
     * @param int $user_id The ID of the user who is receiving the friend requests.
     * @param int $limit The number of records to fetch per page (default is 10).
     * @param int $page The page number for pagination (default is 1).
     * @return array|null A list of incoming friend requests, or null if no results are found.
     */
    public function incomingFriendRequest(int $user_id, int $limit = 10, int $page = 1): ?array
    {
        return $this->select('id, user_id, friend_id')->where([
            'friend_id' => $user_id,
            'status' => 'pending'
        ])->paginate($limit, 'page', $page);
    }

    /**
     * Accepts or rejects a friend request based on the provided status.
     *
     * @param int $requestId The ID of the friend request.
     * @param int $userId The ID of the user who is accepting or rejecting the request.
     * @param bool $accept A boolean value where true accepts the request, and false rejects it.
     * @return bool Returns true if the request was successfully updated, false otherwise.
     * @throws ReflectionException
     */
    public function acceptOrRejectRequest(int $requestId, int $userId, bool $accept): bool
    {
        $request = $this->where('id', $requestId)->where('status', 'pending')->first();

        if (!$request || $request->friend_id != $userId) {
            return false;
        }

        $status = $accept ? 'accepted' : 'rejected';

        $updateStatus = $this->update($requestId, ['status' => $status]);

        return (bool)$updateStatus;
    }

    /**
     * Checks whether a friendship exists between two users.
     *
     * @param int $userId The ID of the first user.
     * @param int $friendId The ID of the second user.
     * @return bool Returns true if the users are friends, false otherwise.
     */
    public function checkFriendship(int $userId, int $friendId): bool
    {
        $query = $this->where([
            'user_id' => $userId,
            'friend_id' => $friendId,
            'status' => 'accepted'
        ])->orWhere([
            'user_id' => $friendId,
            'friend_id' => $userId,
            'status' => 'accepted'
        ])->first();

        return (bool)$query;
    }
}
