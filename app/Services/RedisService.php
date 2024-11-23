<?php
namespace App\Services;

use Predis\Client as PredisClient;

class RedisService extends PredisClient
{
    public function __construct()
    {
        $redisConfig = config('redis');
        parent::__construct([
            'scheme' => 'tcp',
            'host'   => $redisConfig->host,
            'port'   => $redisConfig->port,
            'password' => $redisConfig->password,
            'database' => $redisConfig->database,
        ]);
    }
}
