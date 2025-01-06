<?php

namespace App\Interfaces\Services;

interface IAdminService
{
    public function listUsers(): ?array;
    public function listLogs(): ?array;
    public function listFriendships(): ?array;
    public function listTasks(): ?array;
    public function listQueues(): ?array;
    public function listTaskUsers(): ?array;
    public function listTranslations(string $locale);
}