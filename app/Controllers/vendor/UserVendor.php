<?php
namespace App\Controllers\vendor;

use App\Controllers\BaseController;
use App\Models\vendor\UserVendorModel;
use App\Models\vendor\UserVerifyModel;

class UserVendor extends BaseController
{
    protected $UserVendorModel;
    protected $UserVerifyModel;

    public function __construct()
    {
        $this->UserVendorModel = new UserVendorModel();
        $this->UserVerifyModel = new UserVerifyModel();
        helper(['form', 'url']);
    }

    public function ajaxRegister()
    {
        try {
            $emailAddr = $this->request->getPost('email');

            // Check if email exists
            if ($this->UserVendorModel->where('email', $emailAddr)->first()) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Email already registered. Please log in.'
                ]);
            }

            // Generate verification code
            $verificationCode = random_int(100000, 999999);

            // Save user data for verification
            $insertData = [
                'username'          => $this->request->getPost('username'),
                'email'             => $emailAddr,
                'password'          => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'phone'             => $this->request->getPost('phone'),
                'store_name'        => $this->request->getPost('store_name'),
                'verification_code' => $verificationCode,
                'code_expires_at'   => date('Y-m-d H:i:s', strtotime('+15 minutes'))
            ];

            $insertId = $this->UserVerifyModel->insert($insertData);

            if (!$insertId) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'User registration failed.'
                ]);
            }

            // Send verification email
            $email = \Config\Services::email();
            $email->setFrom('noreplyzem63@gmail.com', 'Zem e-commerce');
            $email->setTo($emailAddr);
            $email->setSubject('Email Verification Code');
            $email->setMessage("Your verification code is: <b>$verificationCode</b>. It will expire in 15 minutes.");

            if (! $email->send()) {
                log_message('error', $email->printDebugger(['headers', 'subject', 'body']));
                $email->clear(true);
                $email->SMTPKeepAlive = false;
                unset($email);
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Unable to send verification email.'
                ]);
                
            }

            $email->clear(true);
            $email->SMTPKeepAlive = false;
            unset($email);
            return $this->response->setJSON([
                'status'   => 'success',
                'redirect' => site_url('public/vendor/verify?email=' . urlencode($emailAddr))
            ]);
            

        } catch (\Throwable $e) {
            log_message('error', 'Registration error: ' . $e->getMessage());

            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'An unexpected error occurred.'
            ]);
        }
    }

    public function ajaxLogin()
    {
        $emailAddr = $this->request->getPost('email');
        $userData  = $this->UserVendorModel->where('email', $emailAddr)->first();

        if (! $userData) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Email not registered. Please register.'
            ]);
        }

        if (! password_verify($this->request->getPost('password'), $userData['password'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Wrong password.'
            ]);
        }

        // Set session
        session()->set([
            'userId'   => $userData['vendor_id'],
            'username' => $userData['username'],
            'email'    => $userData['email'],
            'isLogin'  => true
        ]);

        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Login successful.',
            'redirect' => site_url('vendor/dashboard')
        ]);
    }
}
