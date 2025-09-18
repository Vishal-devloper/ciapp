<?php
namespace App\Controllers\user;  

use App\Controllers\BaseController;




class ShopUserController extends BaseController
{
    
    

    public function __construct()
    {
        helper(['form', 'url']);
    }
    
    public function index():string
    {
        return view('ecommerce/user/dashboard/index');
    }
    public function not_found():string
    {
        return view('ecommerce/user/dashboard/not_found');
    }
    public function about_us():string
    {
        return view('ecommerce/user/dashboard/about_us');
    }
    public function cart():string
    {
        return view('ecommerce/user/dashboard/cart');
    }
    public function checkout():string
    {
        return view('ecommerce/user/dashboard/checkout');
    }
    public function contact():string
    {
        return view('ecommerce/user/dashboard/contact');
    }
    public function my_account():string
    {
        return view('ecommerce/user/dashboard/my_account');
    }
    public function privacy_policy():string
    {
        return view('ecommerce/user/dashboard/privacy_policy');
    }
    public function terms_of_service():string
    {
        return view('ecommerce/user/dashboard/terms_of_service');
    }
    public function wishlist():string
    {
        return view('ecommerce/user/dashboard/wishlist');
    }
    public function blog():string
    {
        return view('ecommerce/user/dashboard/blog');
    }
    public function login():string
    {
        return view('ecommerce/user/dashboard/login');
    }
    public function register():string
    {
        return view('ecommerce/user/dashboard/register');
    }
    public function forgot_password():string
    {
        return view('ecommerce/user/dashboard/forgot_password');
    }
    public function reset_password():string
    {
        return view('ecommerce/user/dashboard/reset_password');
    }
    public function shop():string
    {
        return view('ecommerce/user/dashboard/shop');
    }
    public function single_product():string
    {
        return view('ecommerce/user/dashboard/single_product');
    }
}
