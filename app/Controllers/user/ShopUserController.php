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
    
    
}
