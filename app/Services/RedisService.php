<?php
namespace App\Services;

use App\Interfaces\Services\IRedisService;
use Config\Redis;
use Predis\Client as PredisClient;

class RedisService extends PredisClient implements IRedisService
{
    /** @var Redis  */
    private $redisConfig;
    public function __construct()
    {
        $this->redisConfig = config('redis');
        parent::__construct([
            'scheme' => 'tcp',
            'host'   => $this->redisConfig->host,
            'port'   => $this->redisConfig->port,
            'password' => $this->redisConfig->password,
            'database' => $this->redisConfig->database,
        ]);
    }

    public function getAllQueues(): array
    {
        return $this->zRange('queues:emails:default', 0, -1);
    }

    public function AddEmailQueue(string $email, string $subject, string $message): bool
    {
        $data = [
            'email'    => $email,
            'subject' => $subject,
            'message'  => $message
        ];

        return service('queue')->push('emails', 'email', $data);
    }
}