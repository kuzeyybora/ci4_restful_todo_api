<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskUserModel extends Model
{
    protected $table            = 'task_user';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields    = ['user_id', 'task_id'];
}
