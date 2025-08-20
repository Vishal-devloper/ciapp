<?php
namespace App\Controllers\admin;  

use App\Controllers\BaseController;
use App\Models\admin\UserModel;


class ShopAdminController extends BaseController
{
    
    protected $UserModel;

    public function __construct()
    {
        $this->UserModel = new UserModel();
        helper(['form', 'url']);
    }
    
    public function login():string
    {
        return view('ecommerce/admin/user/login');
    }
    public function verify():string
    {
        return view('ecommerce/admin/user/verify');
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
        $session=session();
        $data['user']=$this->UserModel->find($session->get('id'));
        return view('ecommerce/admin/dashboard/profile',$data);
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
    
    
}
