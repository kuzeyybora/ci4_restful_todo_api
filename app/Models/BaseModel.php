<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model {

    /**
     * Retrieves the model name of the current class by extracting the class name.
     *
     * @return string The name of the model (class) without the namespace.
     */
    public function getModelName(): string
    {
        return basename(str_replace('\\', '/', get_class($this)));
    }
}