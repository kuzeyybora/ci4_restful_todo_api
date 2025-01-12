<?php

namespace App\Services;

use App\Constants\TranslationKeys;
use App\Exception\ValidationException;
use App\Interfaces\Services\IValidationService;

class ValidationService implements IValidationService
{
    /**
     * Sanitize the input data by removing HTML tags and encoding special characters.
     *
     * @param array|string|null $data The input data to be sanitized.
     * @return array|string The sanitized input.
     */
    public function sanitizeInput(array|string|null $data): array|string
    {
        return is_array($data)
            ? array_map([$this, 'sanitizeInput'], $data)
            : htmlspecialchars(strip_tags($data), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Validate and sanitize the provided data according to the given validation rule.
     *
     * @param array|null $data The data to be validated and sanitized.
     * @param array $validationRules The name of the validation rule to apply.
     * @throws ValidationException
     */
    public function validateAndSanitize(?array $data, array $validationRules): object
    {
        $data = $this->sanitizeInput($data ?? []);

        $validation = service('validation');

        $combinedRules = [];

        foreach ($validationRules as $rule) {
            $combinedRules = array_merge($combinedRules, config('validation')->$rule);
        }

        if (!$validation->setRules($combinedRules)->run($data)) {
            throw new ValidationException(
                $validation->getErrors(),
                get_message(TranslationKeys::VALIDATION_FAIL)->value
            );
        }
        return (object) $data;
    }


}