<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/admin/dashboard', 'admin\ShopAdminController::dashboard');
$routes->get('/admin/profile', 'admin\ShopAdminController::profile');
$routes->get('/admin/error', 'admin\ShopAdminController::error');
$routes->get('/admin/basic_table', 'admin\ShopAdminController::basic_table');
$routes->get('/admin/blank', 'admin\ShopAdminController::blank');
$routes->get('/admin/fontawesome', 'admin\ShopAdminController::fontawesome');
$routes->get('/admin/map_google', 'admin\ShopAdminController::map_google');
$routes->get('/admin/login','admin\ShopAdminController::login');
$routes->get('/admin/register','admin\ShopAdminController::register');
$routes->post('admin/User/ajaxRegister', 'admin\User::ajaxRegister');
// $routes->get('/admin/sample','admin/ShopAdminController::sample');
