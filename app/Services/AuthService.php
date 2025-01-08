<?php

namespace App\Services;

use App\Interfaces\Services\IAuthService;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

class AuthService implements IAuthService
{
    /**
     * Authenticates a user with the provided email and password.
     *
     * @param string $email The user's email address.
     * @param string $password The user's password.
     *
     * @return string Returns a personal access token (PAT) if successful, or false if authentication fails.
     */
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
            auth()->getUser()->revokeAllAccessTokens();
            $userObject = new UserModel();
            $userData = $userObject->findById(auth()->id());
            $token = $userData->generateAccessToken("PAT");
            return $token->raw_token;
        }
    }

    /**
     * Registers a new user with the provided details.
     *
     * @param string $username The desired username for the new user.
     * @param string $email The email address of the new user.
     * @param string $password The password for the new user.
     *
     * @return bool Returns true if the user is successfully registered, or false otherwise.
     */
    public function register(string $username, string $email, string $password): bool
    {
        $userObject = new UserModel();

        $userEntityObject = new User([
            "username" => $username,
            "email" => $email,
            "password" => $password,
        ]);

        return $userObject->save($userEntityObject);
    }

    /**
     * Logs out the currently authenticated user.
     *
     * @return bool Returns true if the logout is successful, or false otherwise.
     */
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
