<?php
namespace App\Controllers\vendor;  

use App\Controllers\BaseController;
use App\Models\Users as UserModel; 
use App\Models\Images; 

class ShopVendorController extends BaseController
{
    protected $UserModel;
    protected $Images;
    protected $data=[];

    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->Images = new Images();
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
    
    public function profileImg(){
        $session=session();
        $this->data['user']=$this->UserModel->find($session->get('vendor_id'));
        $Images=$this->data['user']['image_id'] ?? null;
        if($Images){
            $this->data['profileImage']=$this->Images->find($Images);
        }
        else{
            $this->data['profileImage']=['profile_path'=>'vendor/plugins/images/users/genu.jpg'];
        }
    }
    public function dashboard(): string
    {   
        $this->profileImg();
        return view('ecommerce/vendor/dashboard/dashboard',$this->data);
    }
    
    public function profile()
    {   
        $this->profileImg();
        $logoID=$this->data['user']['image_id'] ?? null;
        if($logoID){
            $this->data['logoImage']=$this->Images->find($logoID);
        }
        else{
            $this->data['logoImage']=['logo_path'=>'vendor/plugins/images/users/default_logo.jpg'];
        }
        
        
        return view('ecommerce/vendor/dashboard/profile',$this->data);
    }
    public function map_google(): string
    {   
        $this->profileImg();
        return view('ecommerce/vendor/dashboard/map_google',$this->data);
    }
    public function error(): string
    {   
        return view('ecommerce/vendor/dashboard/error');
    }
    public function basic_table(): string
    {   
        $this->profileImg();
        return view('ecommerce/vendor/dashboard/basic_table',$this->data);
    }
    public function fontawesome(): string
    {   
        $this->profileImg();
        return view('ecommerce/vendor/dashboard/fontawesome',$this->data);
    }
    public function blank(): string
    {   $this->profileImg();
        return view('ecommerce/vendor/dashboard/blank',$this->data);
    }

    
    
}
