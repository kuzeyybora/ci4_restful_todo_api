<?php

namespace App\Interfaces\Services;

interface IFriendshipService
{
    public function sendFriendRequest(int $targetUserId): bool;

    public function listIncomingFriendRequests(int $limit, int $page): ?array;
    public function acceptOrRejectFriendshipRequest(int $request_id, bool $status): bool;
    public function listFriendships(int $limit, int $page): ?array;
}
