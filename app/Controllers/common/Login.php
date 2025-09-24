<?php

namespace App\Controllers\common;

use App\Controllers\BaseController;
use App\Models\Users as UserModel;
// use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Login extends BaseController
{


    protected $UserModel;
    

    public function __construct()
    {
        $this->UserModel = new UserModel();
        helper(['form', 'url', 'jwt']);
    }

    public function ajaxLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // 🔹 Check Admin
        $admin = $this->UserModel->where('email', $email)->first();
        if ($admin['role'] === 'admin') {
            if (!password_verify($password, $admin['password'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Wrong password.'
                ]);
            }



            // ✅ Return JWT + success
            $token = getJWTForUser($admin['id'], $admin['email'], $admin['role']);
            $session = session();
            $session->set([
                'admin_id' => $admin['id'],
                'token' => $token
            ]);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Admin login successful.',
                'token' => $token,
                'role' => 'admin',
                'redirect' => site_url('admin/dashboard')
            ]);
        }

        // 🔹 Check Vendor
        $vendor = $this->UserModel->where('email', $email)->first();
        if ($vendor['role'] === 'vendor') {
            if (!password_verify($password, $vendor['password'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Wrong password.'
                ]);
            }


            // ✅ Return JWT + success
            $token = getJWTForUser($vendor['id'], $vendor['email'], $vendor['role']);
            $session = session();
            $session->set([
                'vendor_id' => $vendor['id'],
                'token' => $token
            ]);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Vendor login successful.',
                'token' => $token,
                'role' => 'vendor',
                'redirect' => site_url('vendor/dashboard')
            ]);
        }

        // 🔹 If email not found in both tables
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Email not registered. Please register.'
        ]);
    }
}
