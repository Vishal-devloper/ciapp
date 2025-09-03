<?php

namespace App\Controllers\common;

use App\Controllers\BaseController;
use App\Models\admin\UserModel as AdminUserModel;
use App\Models\vendor\UserModel as VendorUserModel;
// use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Login extends BaseController
{
    

    protected $adminUserModel;
    protected $vendorUserModel;

    public function __construct()
    {
        $this->adminUserModel  = new AdminUserModel();
        $this->vendorUserModel = new VendorUserModel();
        helper(['form', 'url','jwt']);
    }

    public function ajaxLogin()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // 🔹 Check Admin
        $admin = $this->adminUserModel->where('email', $email)->first();
        if ($admin) {
            if (!password_verify($password, $admin['password'])) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Wrong password.'
                ]);
            }

            

            // ✅ Return JWT + success
            $token = getJWTForUser($admin['id'], $admin['email'], $admin['role']);
            $session=session();
            $session->regenerate(true);
            $session->set([
                'id'=>$admin['id'],
                'token'=>$token
            ]);
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Admin login successful.',
                'token'   => $token,
                'role'    => 'admin',
                'redirect' => site_url('admin/dashboard')
            ]);
        }

        // 🔹 Check Vendor
        $vendor = $this->vendorUserModel->where('email', $email)->first();
        if ($vendor) {
            if (!password_verify($password, $vendor['password'])) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Wrong password.'
                ]);
            }

            
            // ✅ Return JWT + success
            $token = getJWTForUser($vendor['id'], $vendor['email'], $vendor['role']);
            $session=session();
            $session->regenerate(true);
            $session->set([
                'id'=>$vendor['id'],
                'token'=>$token
            ]);
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Vendor login successful.',
                'token'   => $token,
                'role'    => 'vendor',
                'redirect' => site_url('vendor/dashboard')
            ]);
        }

        // 🔹 If email not found in both tables
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Email not registered. Please register.'
        ]);
    }
}
