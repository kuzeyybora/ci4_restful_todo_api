<?php

namespace App\Services;

use App\Interfaces\Services\IBaseService;

class BaseService implements IBaseService {
    public string $modelName;
    public int $userId;
    /**
     * Retrieves the name of the current service.
     *
     * @return string The name of the service, derived from the class name.
     */
    public function getServiceName(): string
    {
        return basename(str_replace('\\', '/', get_class($this)));
    }
}