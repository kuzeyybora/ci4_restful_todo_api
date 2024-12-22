<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->resource('tasks', ['controller' => 'TaskController', 'filter' => 'apiAuth']);
$routes->post('tasks/assignTask', 'TaskController::assignTask', ['filter' => 'apiAuth']);

$routes->group('friendship', ['filter' => 'apiAuth'], function ($routes) {
    $routes->post('send-request/(:num)', 'FriendshipController::sendRequest/$1');
    $routes->get('incoming-requests', 'FriendshipController::listIncomingRequests');
    $routes->post('accept-request', 'FriendshipController::acceptFriendship');
    $routes->post('reject-request', 'FriendshipController::rejectFriendship');
    $routes->get('friends', 'FriendshipController::listFriendships');
});
// $routes->get('mutual-friends', 'FriendshipController::listMutualFriends');
// $routes->post('block', 'FriendshipController::block');
// $routes->post('unblock', 'FriendshipController::unblock');
// $routes->get('blocked', 'FriendshipController::listBlockedUsers');
// service('auth')->routes($routes);

$routes->post('/login', 'AuthController::login');
$routes->post('/register', 'AuthController::register');
$routes->post('/logout', 'AuthController::logout');
