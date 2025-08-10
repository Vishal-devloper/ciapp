<?php
namespace App\Controllers\admin;  

use App\Controllers\BaseController;
use App\Models\admin\UserModel;

class User extends BaseController
{
    protected $UserModel;
    public function __construct()
    {
        $this->UserModel = new UserModel();
        helper(['form', 'url']);
    }
    public function ajaxRegister(){
        $data=[
            'username' =>$this->request->getPost('username'),
            'email' =>$this->request->getPost('email'),
            'password' =>password_hash($this->request->getPost('password'),PASSWORD_DEFAULT)
        ];

        if($this->UserModel->insert($data)){
            return $this->response->setJSON(['status'=>'success']);
        }
        else{
            return $this->response->setJSON(['status'=>'error','message'=>'User Registration Failed']);
        }
        
    }
}