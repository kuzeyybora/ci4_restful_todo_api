<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model {
    public function getModelName(): string
    {
        return basename(str_replace('\\', '/', get_class($this)));
    }
}