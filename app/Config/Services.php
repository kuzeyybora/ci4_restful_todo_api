<?php

namespace Config;

use App\Services\AuthService;
use App\Services\FriendshipService;
use App\Services\RedisService;
use App\Services\TaskService;
use App\Services\ValidationService;
use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */
    public static function validationService(bool $getShared = true): object
    {
        if ($getShared) {
            return static::getSharedInstance('validationService');
        }

        return new ValidationService();
    }

    public static function taskService(bool $getShared = true): object
    {
        if ($getShared) {
            return static::getSharedInstance('taskService');
        }

        return new TaskService();
    }
    public static function friendshipService(bool $getShared = true): object
    {
        if ($getShared) {
            return static::getSharedInstance('friendshipService');
        }

        return new FriendshipService();
    }

    public static function authService(bool $getShared = true): object
    {
        if ($getShared) {
            return static::getSharedInstance('authService');
        }

        return new AuthService();
    }
    public static function redisService(bool $getShared = true): object
    {
        if ($getShared) {
        return static::getSharedInstance('redisService');
        }

        return new RedisService();
    }
}
