<?php

namespace App\Interfaces\Services;

interface IValidationService
{
    public function sanitizeInput(array|string $data): array|string;
    public function validateAndSanitize(array $data, array $validationRules);
}
