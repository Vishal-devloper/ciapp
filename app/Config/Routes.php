<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/admin/dashboard', 'admin\ShopAdminController::dashboard', ['filter' => 'auth']);
$routes->get('/admin/profile', 'admin\ShopAdminController::profile', ['filter' => 'auth']);
$routes->get('/admin/error', 'admin\ShopAdminController::error', ['filter' => 'auth']);
$routes->get('/admin/basic_table', 'admin\ShopAdminController::basic_table', ['filter' => 'auth']);
$routes->get('/admin/blank', 'admin\ShopAdminController::blank', ['filter' => 'auth']);
$routes->get('/admin/fontawesome', 'admin\ShopAdminController::fontawesome', ['filter' => 'auth']);
$routes->get('/admin/map_google', 'admin\ShopAdminController::map_google', ['filter' => 'auth']);
$routes->get('/admin/login','admin\ShopAdminController::login');
$routes->get('/admin/register','admin\ShopAdminController::register');
$routes->post('admin/User/ajaxRegister', 'admin\User::ajaxRegister');
$routes->post('admin/User/ajaxLogin', 'admin\User::ajaxLogin');
// $routes->get('/admin/sample','admin/ShopAdminController::sample');
