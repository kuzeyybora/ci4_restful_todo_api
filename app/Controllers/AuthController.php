<?php

namespace App\Controllers;

use App\Constants\TranslationKeys;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;
use App\Services\ValidationService;

class AuthController extends BaseController
{
    public ValidationService $validationService;
    public function __construct()
    {
        $this->validationService = new ValidationService();
    }

    public function login(): ResponseInterface
    {
        if (auth()->loggedIn()) { auth()->logout(); }
        $requestData = $this->validationService->validateAndSanitize($this->request->getJSON(true), 'user_login');

        if (!$requestData->status) {
            return response_fail(message: TranslationKeys::VALIDATION_FAIL, data: $requestData->errors);
        }

        $credentials = [
            "email" => $requestData->data["email"],
            "password" => $requestData->data["password"],
        ];

        $loginAttempt = auth()->attempt($credentials);

        if (!$loginAttempt->isOK()) {
            return response_fail(message: TranslationKeys::LOGIN_FAIL);
        } else {
            $userObject = new UserModel();
            $userData = $userObject->findById(auth()->id());
            $token = $userData->generateAccessToken("PAT");
            $auth_token = $token->raw_token;
            return response_success(['token' => $auth_token],TranslationKeys::LOGIN_SUCCESS);
        }
    }
    public function register(): ResponseInterface
    {
        $requestData = $this->validationService->validateAndSanitize($this->request->getJSON(true), 'user_register');

        if (!$requestData->status) {
            return response_fail(message: TranslationKeys::VALIDATION_FAIL, data: $requestData->errors);
        }

        $userObject = new UserModel();

        $userEntityObject =  new User([
            "username" => $requestData->data["username"],
            "email" => $requestData->data["email"],
            "password" => $requestData->data["password"],
        ]);

        $userObject->save($userEntityObject);
        return response_success(message: TranslationKeys::REGISTER_SUCCESS);
    }
    public function logout(): ResponseInterface
    {
        if (auth()->loggedIn()) {
            auth()->user()->revokeAllAccessTokens();
            auth()->logout();
            return response_success(message: TranslationKeys::LOGOUT_SUCCESS);
        }
        return response_fail(message: TranslationKeys::LOGOUT_FAIL);
    }
}
