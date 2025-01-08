<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class TaskEntity extends Entity
{
    protected $attributes = [
        'id' => null,
        'title' => null,
        'description' => null,
        'status' => null,
        'created_at' => null,
        'updated_at' => null,
    ];
    public function isCompleted(): bool
    {
        return $this->attributes['status'] === 'completed';
    }

    public function getLowercaseTitle(): string
    {
        return strtolower($this->attributes['title']);
    }
    public function getShortDescription(int $length = 50): string
    {
        if (strlen($this->attributes['description']) <= $length) {
            return $this->attributes['description'];
        }

        return substr($this->attributes['description'], 0, $length) . '...';
    }
}
