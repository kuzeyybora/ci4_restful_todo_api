<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->resource('tasks', ['controller' => 'TaskController', 'filter' => 'apiAuth']);
$routes->post('tasks/assignTask', 'TaskController::assignTask', ['filter' => 'apiAuth']);
$routes->get('tasks', 'TaskController::index', ['filter' => 'apiAuth']);
$routes->get('tasks/(:num)/(:num)', 'TaskController::index/$1/$2', ['filter' => 'apiAuth']);

$routes->group('friendship', ['filter' => 'apiAuth'], function ($routes) {
    $routes->post('send-request/(:num)', 'FriendshipController::sendRequest/$1');
    $routes->get('incoming-requests', 'FriendshipController::listIncomingRequests');
    $routes->get('incoming-requests/(:num)/(:num)', 'FriendshipController::listIncomingRequests/$1/$2');
    $routes->post('accept-request/(:num)', 'FriendshipController::acceptFriendship/$1');
    $routes->post('reject-request/(:num)', 'FriendshipController::rejectFriendship/$1');
    $routes->get('friends', 'FriendshipController::listFriendships');
    $routes->get('friends/(:num)/(:num)', 'FriendshipController::listFriendships/$1/$2');
});

$routes->group('admin', ['filter' => ['apiAuth', 'roleFilter']], function ($routes) {
    $routes->get('index', 'AdminController::index');
    $routes->get('users', 'AdminController::listUsers');
    $routes->get('logs', 'AdminController::listLogs');
    $routes->get('friendships', 'AdminController::listFriendships');
    $routes->get('tasks', 'AdminController::listTasks');
    $routes->get('queues', 'AdminController::listQueues');
    $routes->get('task-users', 'AdminController::listTaskUsers');
    $routes->get('translations/(tr|en|de)', 'AdminController::listTranslations/$1');
});


$routes->post('/login', 'AuthController::login');
$routes->post('/register', 'AuthController::register');
$routes->post('/logout', 'AuthController::logout');
