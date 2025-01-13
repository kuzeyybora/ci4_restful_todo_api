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

    /**
     * Handles the login process for a user.
     *
     * If the user is already logged in, they will be logged out first.
     * Validates and sanitizes the request data, then attempts to log in the user.
     *
     * @return ResponseInterface A response containing a success message and token if login is successful,
     *                           or a failure message if login fails.
     */
    public function login(): ResponseInterface
    {
        if (auth()->loggedIn()) { auth()->logout(); }

        $sanitizedData = $this->validationService->validateAndSanitize($this->request->getJSON(true), ['user_login']);

        $loginAttempt = $this->authService->login($sanitizedData->email, $sanitizedData->password);

        return $loginAttempt
            ? response_success(['token' => $loginAttempt],TranslationKeys::LOGIN_SUCCESS)
            : response_fail(message: TranslationKeys::LOGIN_FAIL);

    }

    /**
     * Handles the registration process for a new user.
     *
     * Validates and sanitizes the request data, then attempts to register the user.
     *
     * @return ResponseInterface A response indicating the success or failure of the registration process.
     */
    public function register(): ResponseInterface
    {
        $sanitizedData = $this->validationService->validateAndSanitize($this->request->getJSON(true), ['user_register']);

        return $this->authService->register($sanitizedData->username, $sanitizedData->email, $sanitizedData->password)
            ? response_success(message: TranslationKeys::REGISTER_SUCCESS)
            : response_fail(TranslationKeys::REGISTER_FAIL);
    }

    /**
     * Handles the logout process for the user.
     *
     * Revokes all active tokens and logs the user out.
     *
     * @return ResponseInterface A response indicating the success or failure of the logout process.
     */
    public function logout(): ResponseInterface
    {
        return $this->authService->logout()
            ? response_success(message: TranslationKeys::LOGOUT_SUCCESS)
            : response_fail(TranslationKeys::LOGOUT_FAIL);
    }
}
