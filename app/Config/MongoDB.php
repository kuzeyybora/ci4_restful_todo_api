<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class MongoDB extends BaseConfig
{
    public string $uri = '';
    public string $database = '';
    public string $collection = '';
}
