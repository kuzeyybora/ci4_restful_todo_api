<?php

namespace App\Services;

class ValidationService
{
    public function sanitizeInput(array|string $input): array|string
    {
        return is_array($input)
            ? array_map([$this, 'sanitizeInput'], $input)
            : htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8');
    }

    public function validateAndSanitize(array $data, string $validationRule): object
    {
        $validation = service("validation");
        $sanitizedData = $this->sanitizeInput($data);
        $rules = config("validation")->$validationRule;

        $isValid = $validation->setRules($rules)->run($sanitizedData);

        return (object) [
            'status' => (bool)$isValid,
            'data' => $isValid ? $sanitizedData : [],
            'errors' => $isValid ? [] : $validation->getErrors()
        ];

    }
}