<?php

namespace App\Interfaces\Services;

interface IMongoDBService
{
    public function getAllLogs(int $limit = 10, int $page = 1, array $filters = []): array|null;
    public function getLog(int $id): array|null;
}
