<?php

use CodeIgniter\Router\RouteCollection;
/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->resource('tasks', ['controller' => 'TaskController', 'filter' => 'apiAuth']);
$routes->group('tasks', ['filter' => 'apiAuth'], function ($routes) {
    $routes->post('assignTask', 'TaskController::assignTask');
});

$routes->group('friends', ['filter' => 'apiAuth'], function ($routes) {
    $routes->post('send-request/(:num)', 'FriendshipController::sendRequest/$1');
    $routes->get('requests/incoming', 'FriendshipController::listIncomingRequests');
    $routes->post('requests/accept/(:num)', 'FriendshipController::acceptFriendship/$1');
    $routes->post('requests/reject/(:num)', 'FriendshipController::rejectFriendship/$1');
    $routes->get('list', 'FriendshipController::listFriendships');
});

$routes->group('admin', ['filter' => ['apiAuth', 'roleFilter']], function ($routes) {
    $routes->get('', 'AdminController::index');
    $routes->get('users', 'AdminController::listUsers');
    $routes->get('logs', 'AdminController::listLogs');
    $routes->get('friendships', 'AdminController::listFriendships');
    $routes->get('tasks', 'AdminController::listTasks');
    $routes->get('queues', 'AdminController::listQueues');
    $routes->get('task-users', 'AdminController::listTaskUsers');
    $routes->get('translations/(tr|en|de)', 'AdminController::listTranslations/$1');

    $routes->group('queue', function ($routes) {
        $routes->get('list', 'QueueController::listQueues');
        $routes->post('add', 'QueueController::addQueue');
    });
});


$routes->post('/login', 'AuthController::login');
$routes->post('/register', 'AuthController::register');
$routes->post('/logout', 'AuthController::logout');
