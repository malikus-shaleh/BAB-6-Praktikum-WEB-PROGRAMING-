<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('dashboard', 'Dashboard::index');
$routes->post('dashboard/save', 'Dashboard::save');
$routes->post('dashboard/save_oli', 'Dashboard::save_oli');
$routes->get('dashboard/history', 'Dashboard::history');
$routes->get('dashboard/statistics', 'Dashboard::statistics');
$routes->get('dashboard/delete/(:num)', 'Dashboard::delete/$1');
$routes->get('dashboard/delete_oli/(:num)', 'Dashboard::delete_oli/$1');
