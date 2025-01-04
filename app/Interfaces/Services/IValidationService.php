<?php

namespace App\Interfaces\Services;

interface IValidationService
{
    public function sanitizeInput(array|string $input): array|string;
    public function validateAndSanitize(array $data, string $validationRule): object;
}
