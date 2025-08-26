<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
// Admin 
$routes->get('/admin/dashboard', 'admin\ShopAdminController::dashboard', ['filter' => 'auth']);
$routes->get('/admin/profile', 'admin\ShopAdminController::profile', ['filter' => 'auth']);
$routes->get('/admin/error', 'admin\ShopAdminController::error', ['filter' => 'auth']);
$routes->get('/admin/vendor', 'admin\ShopAdminController::vendor', ['filter' => 'auth']);
$routes->get('/admin/blank', 'admin\ShopAdminController::blank', ['filter' => 'auth']);
$routes->get('/admin/fontawesome', 'admin\ShopAdminController::fontawesome', ['filter' => 'auth']);
$routes->get('/admin/map_google', 'admin\ShopAdminController::map_google', ['filter' => 'auth']);
$routes->get('/admin/login','admin\ShopAdminController::login');
$routes->get('/admin/verify','admin\ShopAdminController::verify');
$routes->get('/admin/register','admin\ShopAdminController::register');
$routes->post('admin/User/ajaxRegister', 'admin\User::ajaxRegister');
$routes->post('admin/User/ajaxLogin', 'admin\User::ajaxLogin');
$routes->post('admin/User/ajaxCodeVerify', 'admin\User::ajaxCodeVerify');
$routes->post('admin/User/ajaxCodeVerifyResend', 'admin\User::ajaxCodeVerifyResend');
$routes->post('admin/User/ajaxUserUpdate', 'admin\User::ajaxUserUpdate');
// Vendors data
$routes->post('admin/Vendor/getVendors', 'admin\Vendor::getVendors');


// Vendor
$routes->get('/vendor/dashboard', 'vendor\ShopVendorController::dashboard', ['filter' => 'vendorAuth']);
$routes->get('/vendor/profile', 'vendor\ShopVendorController::profile', ['filter' => 'vendorAuth']);
$routes->get('/vendor/error', 'vendor\ShopVendorController::error', ['filter' => 'vendorAuth']);
$routes->get('/vendor/basic_table', 'vendor\ShopVendorController::basic_table', ['filter' => 'vendorAuth']);
$routes->get('/vendor/blank', 'vendor\ShopVendorController::blank', ['filter' => 'vendorAuth']);
$routes->get('/vendor/fontawesome', 'vendor\ShopVendorController::fontawesome', ['filter' => 'vendorAuth']);
$routes->get('/vendor/map_google', 'vendor\ShopVendorController::map_google', ['filter' => 'vendorAuth']);
$routes->get('/vendor/login','vendor\ShopVendorController::login');
$routes->get('/vendor/verify','vendor\ShopVendorController::verify');
$routes->get('/vendor/register','vendor\ShopVendorController::register');
$routes->post('vendor/User/ajaxRegister', 'vendor\User::ajaxRegister');
$routes->post('vendor/User/ajaxLogin', 'vendor\User::ajaxLogin');
$routes->post('vendor/User/ajaxCodeVerify', 'vendor\User::ajaxCodeVerify');
$routes->post('vendor/User/ajaxCodeVerifyResend', 'vendor\User::ajaxCodeVerifyResend');
$routes->post('vendor/User/ajaxUserUpdate', 'vendor\User::ajaxUserUpdate');

