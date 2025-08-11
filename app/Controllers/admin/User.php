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
    public function ajaxRegister()
    {
        // check if email already exists
        $email = $this->request->getPost('email');
        $email_check = $this->UserModel->where('email', $email)->first();

        if ($email_check) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Email Already Registered Please Login']);
        } else {
            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
            ];

            if ($this->UserModel->insert($data)) {
                return $this->response->setJSON(['status' => 'success', 'redirect' => site_url('public/admin/login')]);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'User Registration Failed']);
            }
        }



    }
    public function ajaxLogin()
    {
        $email = $this->request->getPost('email');
        $email_check = $this->UserModel->where('email', $email)->first();

        if ($email_check) {
            $storedHash = $email_check['password'];
            if (password_verify($this->request->getPost('password'), $storedHash)) {
                $userSession=session();
                $userSession->set([
                    'userId'=>$email_check['admin_id'],
                    'username'=>$email_check['username'],
                    'email'=>$email_check['email'],
                    'isLogin'=>true
                ]);
                return $this->response->setJSON(['status' => 'success', 'message' => 'Login Success', 'redirect' => site_url('public/admin/dashboard')]);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Wrong Password']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Email Not Registered Please Register']);
        }
    }
}