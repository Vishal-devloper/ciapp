<?php
namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\admin\UserModel;
use App\Models\admin\UserVerifyModel;
use App\Models\admin\PasswordReset;

class User extends BaseController
{
    protected $UserModel;
    protected $UserVerifyModel;
    protected $PasswordReset;

    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->PasswordReset = new PasswordReset();
        $this->UserVerifyModel = new UserVerifyModel();
        helper(['form', 'url']);
    }

    public function ajaxRegister()
    {
        try {
            $emailAddr = $this->request->getPost('email');

            // Check if email exists
            if ($this->UserModel->where('email', $emailAddr)->first()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Email already registered. Please log in.'
                ]);
            }
            $currentUser = $this->UserVerifyModel->where('email', $emailAddr)->first();
            if ($currentUser) {

                // Generate verification code
                $verificationCode = random_int(100000, 999999);

                // Save user data for verification
                $insertData = [
                    'name' => $this->request->getPost('username'),
                    'email' => $emailAddr,
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'verification_code' => $verificationCode,
                    'code_expires_at' => date('Y-m-d H:i:s', strtotime('+15 minutes')),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $insertId = $this->UserVerifyModel->update($currentUser['id'], $insertData);

                if (!$insertId) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'User registration failed.'
                    ]);
                }

                // Send verification email
                $email = \Config\Services::email();
                $email->setFrom('noreplyzem63@gmail.com', 'Zem e-commerce');
                $email->setTo($emailAddr);
                $email->setSubject('Email Verification Code');
                $email->setMessage("Your verification code is: <b>$verificationCode</b>. It will expire in 15 minutes.");

                if (!$email->send()) {
                    log_message('error', $email->printDebugger(['headers', 'subject', 'body']));
                    $email->clear(true);
                    $email->SMTPKeepAlive = false;
                    unset($email);
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Unable to send verification email.'
                    ]);

                }

                $email->clear(true);
                $email->SMTPKeepAlive = false;
                unset($email);
                return $this->response->setJSON([
                    'status' => 'success',
                    'redirect' => site_url('admin/verify?email=' . urlencode($emailAddr))
                ]);
            }

            // Generate verification code
            $verificationCode = random_int(100000, 999999);

            // Save user data for verification
            $insertData = [
                'name' => $this->request->getPost('username'),
                'email' => $emailAddr,
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'verification_code' => $verificationCode,
                'code_expires_at' => date('Y-m-d H:i:s', strtotime('+15 minutes')),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $insertId = $this->UserVerifyModel->insert($insertData);

            if (!$insertId) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'User registration failed.'
                ]);
            }

            // Send verification email
            $email = \Config\Services::email();
            $email->setFrom('noreplyzem63@gmail.com', 'Zem e-commerce');
            $email->setTo($emailAddr);
            $email->setSubject('Email Verification Code');
            $email->setMessage("Your verification code is: <b>$verificationCode</b>. It will expire in 15 minutes.");

            if (!$email->send()) {
                log_message('error', $email->printDebugger(['headers', 'subject', 'body']));
                $email->clear(true);
                $email->SMTPKeepAlive = false;
                unset($email);
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Unable to send verification email.'
                ]);

            }

            $email->clear(true);
            $email->SMTPKeepAlive = false;
            unset($email);
            return $this->response->setJSON([
                'status' => 'success',
                'redirect' => site_url('admin/verify?email=' . urlencode($emailAddr))
            ]);


        } catch (\Throwable $e) {
            log_message('error', 'Registration error: ' . $e->getMessage());

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'An unexpected error occurred.'
            ]);
        }
    }
    public function ajaxCodeVerify()
    {
        $code = $this->request->getPost('code');
        $email = $this->request->getPost('email');

        if (empty($code) || empty($email)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request. Email or code missing.'
            ]);
        }
        $user = $this->UserVerifyModel->where('email', $email)->first();
        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Email not found.'
            ]);
        }


        if (strtotime($user['code_expires_at']) < time()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Verification code expired.'
            ]);
        }
        if ((string) $user['verification_code'] !== (string) $code) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Wrong verification code.'
            ]);
        }
        $this->UserVerifyModel->update($user['id'], [
            'verification_code' => null,
            'code_expires_at' => null,
            'status' => 'verified'
        ]);

        $newAdmin = [
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $user['password'],
            'created_at' => date('Y-m-d H:i:s')

        ];
        $this->UserModel->insert($newAdmin);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Verification successful',
            'redirect' => site_url('admin/login')
        ]);
    }
    // Resend code
    public function ajaxCodeVerifyResend()
    {
        $emailAddr = $this->request->getPost('email');
        $session = session();

        // Track resend attempts
        $attempts = $session->get('resend_attempts_' . $emailAddr) ?? 0;

        if ($attempts >= 4) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'You have reached the maximum resend limit (4 times).'
            ]);
        }
        $user = $this->UserVerifyModel->where('email', $emailAddr)->first();
        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Email not found to resend code please register.'
            ]);
        }
        // Generate verification code
        $verificationCode = random_int(100000, 999999);



        $insertId = $this->UserVerifyModel->update($user['id'], [
            'verification_code' => $verificationCode,
            'code_expires_at' => date('Y-m-d H:i:s', strtotime('+15 minutes'))
        ]);

        if (!$insertId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Resend code failed Please Try again'
            ]);
        }

        // Send verification email
        $email = \Config\Services::email();
        $email->setFrom('noreplyzem63@gmail.com', 'Zem e-commerce');
        $email->setTo($emailAddr);
        $email->setSubject('Email Verification Code');
        $email->setMessage("Your verification code is: <b>$verificationCode</b>. It will expire in 15 minutes.");

        if (!$email->send()) {
            log_message('error', $email->printDebugger(['headers', 'subject', 'body']));
            $email->clear(true);
            $email->SMTPKeepAlive = false;
            unset($email);
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unable to send verification email.'
            ]);

        }
        $session->set('resend_attempts_' . $emailAddr, $attempts + 1);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Email Sent.'
        ]);
    }

    public function ajaxLogin()
    {
        $emailAddr = $this->request->getPost('email');
        $userData = $this->UserModel->where('email', $emailAddr)->first();

        if (!$userData) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Email not registered. Please register.'
            ]);
        }

        if (!password_verify($this->request->getPost('password'), $userData['password'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Wrong password.'
            ]);
        }
        $session = session();
        $session->regenerate(true);
        // Set session
        $session->set([
            'id' => $userData['id'],
            'name' => $userData['name'],
            'email' => $userData['email'],
            'isAdminLogin' => true
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Login successful.',
            'redirect' => site_url('admin/dashboard')
        ]);
    }

    // Update Profile
    public function ajaxUserUpdate()
    {
        $emailAddr = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $newPassword = $this->request->getPost('newPassword');
        $userData = $this->UserModel->where('email', $emailAddr)->first();
        if (!$userData) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Email not registered. Please register.'
            ]);
        }
        if ($password == "" && $newPassword == "") {
            $insertId = $this->UserModel->update(
                $userData['id'],
                [
                    'name' => $this->request->getPost('name')
                ]
            );
            if (!$insertId) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Profile Not Updated Try Again later'
                ]);
            }
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Profile Updated Successfully.'
            ]);
        }

        if (!password_verify($this->request->getPost('password'), $userData['password'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Current Password is Wrong.'
            ]);
        }
        $insertId = $this->UserModel->update(
            $userData['id'],
            [
                'name' => $this->request->getPost('name'),
                'password' => password_hash($this->request->getPost('newPassword'), PASSWORD_DEFAULT)
            ]
        );
        if (!$insertId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Profile Not Updated Try Again later'
            ]);
        }
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Profile Updated Successfully.'
        ]);
    }


    // forgot password

    public function forgotPassword(){
        $emailAddr = $this->request->getPost('email');
        $user=$this->UserModel->where('email',$emailAddr)->first();
        if(!$user){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'Email not registered please register'
            ]);
        }
        // Generate verification code
        $verificationCode = random_int(100000, 999999);

        $data=[
            'email'=>$emailAddr,
            'otp' => $verificationCode,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+15 minutes'))
        ];

        $email_check=$this->PasswordReset->where('email',$emailAddr)->first();
        if(!$email_check){
            $insertId = $this->PasswordReset->insert($data);
        }
        else{
            $insertId = $this->PasswordReset->update($email_check['id'],$data);
        }

        if (!$insertId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Code sending failed Please Try again'
            ]);
        }

        // Send verification email
        $email = \Config\Services::email();
        $email->setFrom('noreplyzem63@gmail.com', 'Zem e-commerce');
        $email->setTo($emailAddr);
        $email->setSubject('Email Verification Code');
        $email->setMessage("Your verification code is: <b>$verificationCode</b>. It will expire in 15 minutes.");

        if (!$email->send()) {
            log_message('error', $email->printDebugger(['headers', 'subject', 'body']));
            $email->clear(true);
            $email->SMTPKeepAlive = false;
            unset($email);
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unable to send verification email.'
            ]);

        }
        
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Email Sent.',
            'redirect'=>site_url('admin/reset-verify?email=' . urlencode($emailAddr))
        ]);

    }
    // forgot password code verify

    public function forgotCodeVerify(){
        $code = $this->request->getPost('code');
        $email = $this->request->getPost('email');

        if (empty($code) || empty($email)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request. Email or code missing.'
            ]);
        }
        $user = $this->PasswordReset->where('email', $email)->first();
        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Email not found.'
            ]);
        }


        if (strtotime($user['expires_at']) < time()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Verification code expired.'
            ]);
        }
        if ((string) $user['otp'] !== (string) $code) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Wrong verification code.'
            ]);
        }
        $this->PasswordReset->update($user['id'], [
            'otp' => null,
            'expires_at' => null,
            'status' => 'verified'
        ]);

        
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Verification successful',
            'redirect' => site_url('admin/create-new-password?email='.urlencode($user['email']))
        ]);
    }
    public function forgotCodeVerifyResend(){
        $emailAddr = $this->request->getPost('email');
        $session = session();

        // Track resend attempts
        $attempts = $session->get('resend_attempts_' . $emailAddr) ?? 0;

        if ($attempts >= 4) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'You have reached the maximum resend limit (4 times).'
            ]);
        }
        $user = $this->PasswordReset->where('email', $emailAddr)->first();
        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Email not found to resend code please register.'
            ]);
        }
        // Generate verification code
        $verificationCode = random_int(100000, 999999);



        $insertId = $this->PasswordReset->update($user['id'], [
            'otp' => $verificationCode,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+15 minutes'))
        ]);

        if (!$insertId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Resend code failed Please Try again'
            ]);
        }

        // Send verification email
        $email = \Config\Services::email();
        $email->setFrom('noreplyzem63@gmail.com', 'Zem e-commerce');
        $email->setTo($emailAddr);
        $email->setSubject('Email Verification Code');
        $email->setMessage("Your verification code is: <b>$verificationCode</b>. It will expire in 15 minutes.");

        if (!$email->send()) {
            log_message('error', $email->printDebugger(['headers', 'subject', 'body']));
            $email->clear(true);
            $email->SMTPKeepAlive = false;
            unset($email);
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unable to send verification email.'
            ]);

        }
        $session->set('resend_attempts_' . $emailAddr, $attempts + 1);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Email Sent.'
        ]);
    }
    // New Password
    public function newPassword(){
        $password = $this->request->getPost('password');
        $email = $this->request->getPost('email');

        if (empty($password) || empty($email)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request. Email missing.'
            ]);
        }
        $user = $this->UserModel->where('email', $email)->first();
        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Email not found.'
            ]);
        }
        $insertId=$this->UserModel->update($user['id'],[
            'password'=>password_hash($password,PASSWORD_DEFAULT)
        ]);
        if(!$insertId){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'Password Not updated Please try again'
            ]);
        }

        return $this->response->setJSON([
            'status'=>'success',
            'message'=>'Password Updated Successfully',
            'redirect'=>site_url('admin/login')
        ]);

    }
}

