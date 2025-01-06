<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Redis extends BaseConfig
{
    public string $host = '';
    public string $port = '';
    public string $password = '';
    public string $database = '';
}
