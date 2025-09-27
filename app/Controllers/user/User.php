<?php
namespace App\Controllers\user;
use App\Controllers\BaseController;
use App\Models\Users as UserModel;
use App\Models\PendingUsers;
use App\Models\PasswordReset;

class User extends BaseController
{
    protected $UserModel;
    protected $PendingUsers;
    protected $PasswordReset;

    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->PasswordReset = new PasswordReset();
        $this->PendingUsers = new PendingUsers();
        helper(['form', 'url']);
    }
    public function ajaxRegister(){
        $emailAddr=$this->request->getPost('email');

        $emailCheck=$this->UserModel->where('email',$emailAddr)->first();
        if($emailCheck){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'Email already exists Please Login'
            ]);
        }

    }
}
