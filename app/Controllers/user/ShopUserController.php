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
    
}
