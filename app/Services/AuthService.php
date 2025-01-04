<?php

namespace App\Services;

use App\Interfaces\Services\IAuthService;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

class AuthService implements IAuthService
{
    public function login(string $email, string $password): string
    {
        $credentials = [
            "email" => $email,
            "password" => $password,
        ];

        $loginAttempt = auth()->attempt($credentials);

        if (!$loginAttempt->isOK()) {
            return false;
        } else {
            $userObject = new UserModel();
            $userData = $userObject->findById(auth()->id());
            $token = $userData->generateAccessToken("PAT");
            return $token->raw_token;
        }
    }
    public function register(string $username, string $email, string $password): bool
    {
        $userObject = new UserModel();

        $userEntityObject =  new User([
            "username" => $username,
            "email" => $email,
            "password" => $password,
        ]);

        return $userObject->save($userEntityObject);
    }
    public function logout(): bool
    {
        if (!auth()->loggedIn()) {
            if (auth()->user()->revokeAllAccessTokens() && auth()->logout()) {
                return true;
            }
            return false;
        }
        return true;
    }
}