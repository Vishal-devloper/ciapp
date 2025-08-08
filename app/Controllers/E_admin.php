<?php

namespace App\Controllers;
use App\Models\E_admin_model;
class E_admin extends BaseController
{
     protected $productModel;

    public function __construct()
    {
        $this->productModel = new E_admin_model();
        helper(['form', 'url']);
    }
    public function login():string
    {
        return view('ecommerce/admin/user/login');
    }
    public function register():string
    {
        return view('ecommerce/admin/user/register');
    }
    public function dashboard(): string
    {   
        
        return view('ecommerce/admin/dashboard/dashboard');
    }
    public function profile(): string
    {   
        return view('ecommerce/admin/dashboard/profile');
    }
    public function map_google(): string
    {   
        return view('ecommerce/admin/dashboard/map_google');
    }
    public function error(): string
    {   
        return view('ecommerce/admin/dashboard/error');
    }
    public function basic_table(): string
    {   
        return view('ecommerce/admin/dashboard/basic_table');
    }
    public function fontawesome(): string
    {   
        return view('ecommerce/admin/dashboard/fontawesome');
    }
    public function blank(): string
    {   
        return view('ecommerce/admin/dashboard/blank');
    }
    public function sample(): string
    {   
        $data['products'] = $this->productModel->findAll();
        return view('ecommerce/admin/dashboard/sample',$data);
    }
}
