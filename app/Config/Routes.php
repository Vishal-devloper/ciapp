<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/new', 'Home::new');
$routes->get('/admin/dashboard', 'E_admin::dashboard');
$routes->get('/admin/profile', 'E_admin::profile');
$routes->get('/admin/error', 'E_admin::error');
$routes->get('/admin/basic_table', 'E_admin::basic_table');
$routes->get('/admin/blank', 'E_admin::blank');
$routes->get('/admin/fontawesome', 'E_admin::fontawesome');
$routes->get('/admin/map_google', 'E_admin::map_google');
