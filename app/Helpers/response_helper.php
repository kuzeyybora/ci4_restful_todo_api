<?php

use App\Services\TranslationService;
use CodeIgniter\HTTP\ResponseInterface;
/**
 * Retrieves a translated message for a given key based on the current locale.
 *
 * @param string $key The key for the desired translation.
 * @return object The translated message object.
 */
function get_message(string $key): object
{
    $translationService = new TranslationService();
    $locale = service('language')->getLocale();
    return $translationService->getTranslation($key, $locale);
}

/**
 * Generates a success response with the given data and message.
 *
 * @param array|object|null $data The data to include in the response.
 * @param string $message The message key to retrieve the response message (default: 'RESPONSE_SUCCESSFULLY_MESSAGE').
 * @param int $code The HTTP status code for the response (default: 200).
 * @return ResponseInterface The success response object.
 */
function response_success(array|object $data = null, string $message = 'RESPONSE_SUCCESSFULLY_MESSAGE', int $code = 200): ResponseInterface
{
    $responseData = get_message($message);

    return service('response')->setStatusCode($responseData->status_code ?? $code)->setJSON([
        'status' => true,
        'message' => $responseData->value,
        'data' => $data
    ]);
}

/**
 * Generates a failure response with the given message and data.
 *
 * @param string $message The message key to retrieve the response message (default: 'RESPONSE_UNSUCCESSFULLY_MESSAGE').
 * @param array|object|null $data The data to include in the response.
 * @param int $code The HTTP status code for the response (default: 400).
 * @return ResponseInterface The failure response object.
 */
function response_fail(string $message = 'RESPONSE_UNSUCCESSFULLY_MESSAGE', array|object $data = null, int $code = 400): ResponseInterface
{
    $responseData = get_message($message);

    return service('response')->setStatusCode($responseData->status_code ?? $code)->setJSON([
        'status' => false,
        'message' => $responseData->value,
        'data' => $data
    ]);
}
