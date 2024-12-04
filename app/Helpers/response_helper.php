<?php

use App\Services\TranslationService;
use CodeIgniter\HTTP\ResponseInterface;
function get_message(string $key): object
{
    $translationService = new TranslationService();
    $locale = service('language')->getLocale();
    return $translationService->getTranslation($key, $locale);
}
function response_success(array|object $data = null, string $message = 'RESPONSE_SUCCESSFULLY_MESSAGE', int $code = 200): ResponseInterface
{
    $responseData = get_message($message);

    return service('response')->setStatusCode($responseData->status_code ?? $code)->setJSON([
        'status' => true,
        'message' => $responseData->value,
        'data' => $data
    ]);
}

function response_fail(string $message = 'RESPONSE_UNSUCCESSFULLY_MESSAGE', array|object $data = null, int $code = 200): ResponseInterface
{
    $responseData = get_message($message);

    return service('response')->setStatusCode($responseData->status_code ?? $code)->setJSON([
        'status' => false,
        'message' => $responseData->value,
        'data' => $data
    ]);
}
