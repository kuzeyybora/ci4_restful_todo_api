<?php

namespace App\Controllers;

use App\Constants\TranslationKeys;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

class AuthController extends BaseController
{
    public function __construct()
    {
    }
    public function sanitizeInput(array|string $input): array|string
    {
        return is_array($input)
            ? array_map([$this, 'sanitizeInput'], $input)
            : htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8');
    }

    protected function validateAndSanitize(array $data, string $validationRule): object
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

    public function login(): ResponseInterface
    {
        if (auth()->loggedIn()) { auth()->logout(); }
        $requestData = $this->validateAndSanitize($this->request->getJSON(true), 'userLogin');

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
        $requestData = $this->validateAndSanitize($this->request->getJSON(true), 'userRegister');

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
