<?php

namespace App\Interfaces\Services;

interface IAuthService
{
    public function login(string $email, string $password): string;
    public function register(string $username, string $email, string $password): bool;
    public function logout(): bool;
}
