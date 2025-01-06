<?php

namespace App\Interfaces\Services;

interface IRedisService
{
    public function getAllQueues(): array;
    public function AddEmailQueue(string $email, string $subject, string $message): bool;
}
