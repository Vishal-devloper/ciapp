<?php
namespace App\Controllers\vendor;

use App\Controllers\BaseController;
use App\Models\vendor\UserModel;
use App\Models\vendor\UserVerifyModel;
$email=\Config\Services::email();
class User extends BaseController
{
    protected $UserModel;
    protected $UserVerifyModel;
    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->UserVerifyModel = new UserVerifyModel();
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
            $verificationCode = random_int(100000, 999999);
            $emailAddr=$this->request->getPost('email');
            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $emailAddr,
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'phone'=>$this->request->getPost('phone'),
                'store_name'=>$this->request->getPost('store_name'),
                'verification_code'=>$verificationCode,
                'code_expires_at'   => date('Y-m-d H:i:s', strtotime('+15 minutes'))
            ];

            if ($this->UserVerifyModel->insert($data)) {
            $email = \Config\Services::email();
            $email->setFrom('your-email@gmail.com', 'Your Shop Name');
            $email->setTo($emailAddr);
            $email->setSubject('Email Verification Code');
            $email->setMessage("Your verification code is: <b>$verificationCode</b>. It will expire in 15 minutes.");
                
                if($email->send()){
                    return $this->response->setJSON(['status' => 'verify code', 'redirect' => site_url('public/vendor/verify?email='.urlencode($emailAddr))]);
                }else {
                // Debugging info
                echo $email->printDebugger(['headers']);
            }

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
                    'userId'=>$email_check['vendor_id'],
                    'username'=>$email_check['username'],
                    'email'=>$email_check['email'],
                    'isLogin'=>true
                ]);
                return $this->response->setJSON(['status' => 'success', 'message' => 'Login Success', 'redirect' => site_url('public/vendor/dashboard')]);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Wrong Password']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Email Not Registered Please Register']);
        }
    }
}