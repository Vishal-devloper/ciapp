<?php
namespace App\Controllers\vendor;  

use App\Controllers\BaseController;
// use App\Models\vendor\ShopVendorModel; 

class ShopVendorController extends BaseController
{
    // protected $ShopvendorModel;


    public function __construct()
    {
        // $this->ShopvendorModel = new ShopvendorModel();
        helper(['form', 'url']);
    }
    
    public function login():string
    {
        return view('ecommerce/vendor/user/login');
    }
    public function verify():string
    {
        return view('ecommerce/vendor/user/verify');
    }
    public function register():string
    {
        return view('ecommerce/vendor/user/register');
    }
    public function dashboard(): string
    {   
        
        return view('ecommerce/vendor/dashboard/dashboard');
    }
    public function profile(): string
    {   
        return view('ecommerce/vendor/dashboard/profile');
    }
    public function map_google(): string
    {   
        return view('ecommerce/vendor/dashboard/map_google');
    }
    public function error(): string
    {   
        return view('ecommerce/vendor/dashboard/error');
    }
    public function basic_table(): string
    {   
        return view('ecommerce/vendor/dashboard/basic_table');
    }
    public function fontawesome(): string
    {   
        return view('ecommerce/vendor/dashboard/fontawesome');
    }
    public function blank(): string
    {   
        return view('ecommerce/vendor/dashboard/blank');
    }
    // public function sample(): string
    // {   
    //     $data['products'] = $this->ShopvendorModel->findAll();
    //     return view('ecommerce/vendor/dashboard/sample',$data);
    // }
    
}
