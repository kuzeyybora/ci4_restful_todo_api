<?php

namespace App\Services;

use App\Interfaces\Services\IBaseService;

class BaseService implements IBaseService {
    public string $modelName;
    public int $userId;
    public function getServiceName(): string
    {
        return basename(str_replace('\\', '/', get_class($this)));
    }
}