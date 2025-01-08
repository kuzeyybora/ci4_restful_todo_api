<?php

namespace App\Services;

use App\Interfaces\Services\IValidationService;

class ValidationService implements IValidationService
{
    /**
     * Sanitize the input data by removing HTML tags and encoding special characters.
     *
     * @param array|string $input The input data to be sanitized.
     * @return array|string The sanitized input.
     */
    public function sanitizeInput(array|string $input): array|string
    {
        return is_array($input)
            ? array_map([$this, 'sanitizeInput'], $input)
            : htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Validate and sanitize the provided data according to the given validation rule.
     *
     * @param array $data The data to be validated and sanitized.
     * @param string $validationRule The name of the validation rule to apply.
     * @return object An object containing the validation status, sanitized data, and any errors.
     */
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