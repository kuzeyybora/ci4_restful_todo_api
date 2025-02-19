<?php

namespace App\Models;

use App\Entities\TaskEntity;
use CodeIgniter\Model;

class TaskModel extends BaseModel
{
    protected $table            = 'tasks';
    protected $primaryKey       = 'id';
    protected $returnType       = TaskEntity::class;
    protected $allowedFields    = ['title', 'description', 'status'];

}
