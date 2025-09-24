<?php
namespace App\Controllers\admin;  

use App\Controllers\BaseController;
use App\Models\Users as UserModel;



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
    public function forgotPassword():string
    {
        return view('ecommerce/admin/user/forgotPassword');
    }
    public function resetVerify():string
    {
        return view('ecommerce/admin/user/resetVerify');
    }
    public function newPassword():string
    {
        return view('ecommerce/admin/user/newPassword');
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
        $data['user']=$this->UserModel->find($session->get('admin_id'));
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
    public function vendor(): string
    {
        return view('ecommerce/admin/dashboard/vendor');
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
