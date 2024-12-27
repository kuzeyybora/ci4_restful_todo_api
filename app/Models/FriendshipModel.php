<?php

namespace App\Models;

use App\Entities\FriendshipEntity;
use CodeIgniter\Model;

class FriendshipModel extends Model
{
    protected $table            = 'friendships';
    protected $primaryKey       = 'id';
    protected $returnType       = FriendshipEntity::class;
    protected $allowedFields    = ['user_id', 'friend_id', 'status'];

    public function getAcceptedFriends ($user_id)
    {
        return $this->select('user_id, friend_id')
            ->where('status', 'accepted')
            ->groupStart()
            ->where('user_id', $user_id)
            ->orWhere('friend_id', $user_id)
            ->groupEnd()
            ->findAll();
    }
    public function incomingFriendRequest($user_id)
    {
        return $this->select('id, user_id, friend_id')->where([
            'friend_id' => $user_id,
            'status' => 'pending'
        ])->findAll();
    }
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
