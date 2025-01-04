<?php

namespace App\Controllers;

use App\Constants\TranslationKeys;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public object $validationService;
    public object $authService;
    public function __construct()
    {
        $this->validationService = service('validationService');
        $this->authService = service('authService');
    }

    public function login(): ResponseInterface
    {
        if (auth()->loggedIn()) { auth()->logout(); }
        $requestData = $this->validationService->validateAndSanitize($this->request->getJSON(true), 'user_login');

        if (!$requestData->status) {
            return response_fail(message: TranslationKeys::VALIDATION_FAIL, data: $requestData->errors);
        }

        return ($loginAttempt = $this->authService->login($requestData->data['email'], $requestData->data['password']))
            ? response_success(['token' => $loginAttempt],TranslationKeys::LOGIN_SUCCESS)
            : response_fail(message: TranslationKeys::LOGIN_FAIL);

    }
    public function register(): ResponseInterface
    {
        $requestData = $this->validationService->validateAndSanitize($this->request->getJSON(true), 'user_register');

        if (!$requestData->status) {
            return response_fail(message: TranslationKeys::VALIDATION_FAIL, data: $requestData->errors);
        }

        return $this->authService->register($requestData->data["username"], $requestData->data["email"], $requestData->data["password"])
            ? response_success(message: TranslationKeys::REGISTER_SUCCESS)
            : response_fail(TranslationKeys::REGISTER_FAIL);
    }
    public function logout(): ResponseInterface
    {
        return $this->authService->logout()
            ? response_success(message: TranslationKeys::LOGOUT_SUCCESS)
            : response_fail(TranslationKeys::LOGOUT_FAIL);
    }
}
