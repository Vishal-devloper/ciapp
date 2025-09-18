<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
// Admin 
$routes->group('admin', ['filter' => 'jwt'], function ($routes) {
    $routes->get('dashboard', 'admin\ShopAdminController::dashboard');
    $routes->get('profile', 'admin\ShopAdminController::profile');
    $routes->get('error', 'admin\ShopAdminController::error');
    $routes->get('vendor', 'admin\ShopAdminController::vendor');
    $routes->get('blank', 'admin\ShopAdminController::blank');
    $routes->get('fontawesome', 'admin\ShopAdminController::fontawesome');
    $routes->get('map_google', 'admin\ShopAdminController::map_google');
});
$routes->get('/admin/login', 'admin\ShopAdminController::login');
$routes->get('/admin/verify', 'admin\ShopAdminController::verify');
$routes->get('/admin/register', 'admin\ShopAdminController::register');
$routes->get('/admin/forgot-password', 'admin\ShopAdminController::forgotPassword');
$routes->get('/admin/reset-verify', 'admin\ShopAdminController::resetVerify');
$routes->get('/admin/create-new-password', 'admin\ShopAdminController::newPassword');
$routes->post('admin/User/ajaxRegister', 'admin\User::ajaxRegister');
$routes->post('admin/User/ajaxCodeVerify', 'admin\User::ajaxCodeVerify');
$routes->post('admin/User/forgotCodeVerify', 'admin\User::forgotCodeVerify');
$routes->post('admin/User/forgotCodeVerifyResend', 'admin\User::forgotCodeVerifyResend');
$routes->post('admin/User/ajaxCodeVerifyResend', 'admin\User::ajaxCodeVerifyResend');
$routes->post('admin/User/forgotPassword', 'admin\User::forgotPassword');
$routes->post('admin/User/ajaxUserUpdate', 'admin\User::ajaxUserUpdate');
$routes->post('admin/User/newPassword', 'admin\User::newPassword');
// Vendors data
$routes->post('admin/Vendor/getVendors', 'admin\Vendor::getVendors');
$routes->post('admin/Vendor/vendorUpdate', 'admin\Vendor::vendorUpdate');


// Vendor
$routes->group('vendor', ['filter' => 'jwt'], function ($routes) {
    $routes->get('dashboard', 'vendor\ShopVendorController::dashboard');
    $routes->get('profile', 'vendor\ShopVendorController::profile');
    $routes->get('error', 'vendor\ShopVendorController::error');
    $routes->get('basic_table', 'vendor\ShopVendorController::basic_table');
    $routes->get('blank', 'vendor\ShopVendorController::blank');
    $routes->get('fontawesome', 'vendor\ShopVendorController::fontawesome');
    $routes->get('map_google', 'vendor\ShopVendorController::map_google');
});

$routes->get('/vendor/login', 'vendor\ShopVendorController::login');
$routes->get('/vendor/verify', 'vendor\ShopVendorController::verify');
$routes->get('/vendor/register', 'vendor\ShopVendorController::register');
$routes->get('/vendor/forgot-password', 'vendor\ShopVendorController::forgotPassword');
$routes->get('/vendor/reset-verify', 'vendor\ShopVendorController::resetVerify');
$routes->get('/vendor/create-new-password', 'vendor\ShopVendorController::newPassword');
$routes->post('vendor/User/ajaxRegister', 'vendor\User::ajaxRegister');
$routes->post('vendor/User/ajaxCodeVerify', 'vendor\User::ajaxCodeVerify');
$routes->post('vendor/User/ajaxCodeVerifyResend', 'vendor\User::ajaxCodeVerifyResend');
$routes->post('vendor/User/ajaxUserUpdate', 'vendor\User::ajaxUserUpdate');

$routes->post('vendor/User/newPassword', 'vendor\User::newPassword');
$routes->post('vendor/User/forgotPassword', 'vendor\User::forgotPassword');
$routes->post('vendor/User/forgotCodeVerify', 'vendor\User::forgotCodeVerify');
$routes->post('vendor/User/forgotCodeVerifyResend', 'vendor\User::forgotCodeVerifyResend');




// Login 

$routes->post('common/Login/ajaxLogin', 'common\Login::ajaxLogin');



// User
$routes->get('/user/home', 'user\ShopUserController::index');
$routes->get('/user/404', 'user\ShopUserController::not_found');
$routes->get('/user/about-us', 'user\ShopUserController::about_us');
$routes->get('/user/cart', 'user\ShopUserController::cart');
$routes->get('/user/checkout', 'user\ShopUserController::checkout');
$routes->get('/user/contact', 'user\ShopUserController::contact');
$routes->get('/user/wishlist', 'user\ShopUserController::wishlist');
$routes->get('/user/my-account', 'user\ShopUserController::my_account');
$routes->get('/user/privacy-policy', 'user\ShopUserController::privacy_policy');
$routes->get('/user/terms-of-service', 'user\ShopUserController::terms_of_service');
