<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class FriendshipEntity extends Entity
{
    protected $attributes = [
        'id' => null,
        'user_id' => null,
        'friend_id' => null,
        'status' => null, // pending, accepted, rejected
        'created_at' => null,
        'updated_at' => null,
    ];
}
