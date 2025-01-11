<?php
namespace App\Exception;

use App\Constants\TranslationKeys;
use CodeIgniter\Exceptions\ExceptionInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class ValidationException extends Exception implements ExceptionInterface
{
    protected array $errors;

    public function __construct(array $errors, string $message)
    {
        parent::__construct($message);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getResponse(): ResponseInterface
    {
        return response_fail(TranslationKeys::VALIDATION_FAIL, $this->errors);
    }
}
