<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('api', ['namespace' => 'App\Controllers'], function ($routes) {
  $routes->post('register', 'Auth::register');
  $routes->post('login', 'Auth::login');

  $routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('profile', 'User::profile');
    $routes->resource('measurements');
    $routes->get('measurements/stats', 'Measurements::stats');
  });
});
