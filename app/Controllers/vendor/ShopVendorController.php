<?php
namespace App\Controllers\vendor;  

use App\Controllers\BaseController;
use App\Models\vendor\UserModel; 
use App\Models\vendor\ProfileImg; 

class ShopVendorController extends BaseController
{
    protected $UserModel;
    protected $ProfileImg;


    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->ProfileImg = new ProfileImg();
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
    public function forgotPassword():string
    {
        return view('ecommerce/vendor/user/forgotPassword');
    }
    public function resetVerify():string
    {
        return view('ecommerce/vendor/user/resetVerify');
    }
    public function newPassword():string
    {
        return view('ecommerce/vendor/user/newPassword');
    }
    public function dashboard(): string
    {   
        
        return view('ecommerce/vendor/dashboard/dashboard');
    }
    public function profile()
    {   
        $session=session();
        $data['user']=$this->UserModel->find($session->get('vendor_id'));
        $logoID=$data['user']['store_logo_id'] ?? null;
        if($logoID){
            $data['logoImage']=$this->ProfileImg->find($logoID);
        }
        else{
            $data['logoImage']=['logo_path'=>'vendor/plugins/images/users/default_logo.jpg'];
        }
        $profileImg=$data['user']['profile_img_id'] ?? null;
        if($profileImg){
            $data['profileImage']=$this->ProfileImg->find($profileImg);
        }
        else{
            $data['profileImage']=['profile_path'=>'vendor/plugins/images/users/genu.jpg'];
        }
        
        return view('ecommerce/vendor/dashboard/profile',$data);
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

    
    
}
