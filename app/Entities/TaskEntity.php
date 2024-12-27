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


    // Görev tamamlandı mı?
    public function isCompleted(): bool
    {
        return $this->attributes['status'] === 'completed';
    }

    // Görevin başlığını küçük harfe çevirme
    public function getLowercaseTitle(): string
    {
        return strtolower($this->attributes['title']);
    }

    // Kısa açıklama (örneğin, 50 karakter)
    public function getShortDescription(int $length = 50): string
    {
        if (strlen($this->attributes['description']) <= $length) {
            return $this->attributes['description'];
        }

        return substr($this->attributes['description'], 0, $length) . '...';
    }
}
