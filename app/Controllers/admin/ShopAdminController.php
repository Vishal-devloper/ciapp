<?php
namespace App\Controllers\admin;  

use App\Controllers\BaseController;
use App\Models\admin\UserModel;
use App\Models\admin\VendorModel;


class ShopAdminController extends BaseController
{
    
    protected $UserModel;
    protected $VendorModel;

    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->VendorModel = new VendorModel();
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
    public function vendor(): string
    {   $data['vendors']=$this->VendorModel->findAll();
        return view('ecommerce/admin/dashboard/vendor',$data);
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
