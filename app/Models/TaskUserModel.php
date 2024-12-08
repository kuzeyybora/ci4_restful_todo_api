<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskUserModel extends Model
{
    protected $table            = 'task_user';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields    = ['user_id', 'task_id'];

    public function getUserTasks($user_id)
    {
        $builder = $this->db->table('task_user');
        $builder->select('*');
        $builder->join('tasks', 'tasks.id = task_user.task_id');
        $builder->where('task_user.user_id', $user_id);
        $query = $builder->get();
        return $query->getResult();

        // will be 1 method
    }
    public function getUserTask($user_id, $todo_id)
    {
        return $this->db->table('task_user')
            ->select('*')
            ->join('tasks', 'tasks.id = task_user.task_id')
            ->where('task_user.user_id', $user_id)
            ->where('task_user.task_id', $todo_id)
            ->get()
            ->getRow();

        // will be 1 method
    }
}
