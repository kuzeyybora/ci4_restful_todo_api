<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/tasks', 'TaskController::index');
$routes->get('/tasks/(:num)', 'TaskController::show/$1');
$routes->post('/tasks', 'TaskController::create');

// service('auth')->routes($routes);


$routes->post('/login', 'AuthController::login');
$routes->post('/register', 'AuthController::register');
$routes->post('/logout', 'AuthController::logout');
