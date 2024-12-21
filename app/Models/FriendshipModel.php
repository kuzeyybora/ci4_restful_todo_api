<?php

namespace App\Models;

use CodeIgniter\Model;

class FriendshipModel extends Model
{
    protected $table            = 'friendships';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields    = ['user_id', 'friend_id', 'status'];
}
