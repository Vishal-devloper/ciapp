<?php
namespace App\Controllers\vendor;

use App\Controllers\BaseController;
use App\Models\Users as UserModel;
use App\Models\PendingUsers;
use App\Models\Images;
use App\Models\PasswordReset;

class User extends BaseController
{
    protected $UserModel;
    protected $PendingUsers;
    protected $Images;
    protected $PasswordReset;

    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->PendingUsers = new PendingUsers();
        $this->Images = new Images();
        $this->PasswordReset = new PasswordReset();
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
            $currentUser = $this->PendingUsers->where('email', $emailAddr)->first();
            if ($currentUser) {

                // Generate verification code
                $verificationCode = random_int(100000, 999999);

                // Save user data for verification
                $insertData = [
                    'name' => $this->request->getPost('username'),
                    'email' => $emailAddr,
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'phone' => $this->request->getPost('phone'),
                    'store_name' => $this->request->getPost('store_name'),
                    'verification_code' => $verificationCode,
                    'code_expires_at' => date('Y-m-d H:i:s', strtotime('+15 minutes')),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $insertId = $this->PendingUsers->update($currentUser['id'], $insertData);

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
                    'redirect' => site_url('vendor/verify?email=' . urlencode($emailAddr))
                ]);
            }

            // Generate verification code
            $verificationCode = random_int(100000, 999999);

            // Save user data for verification
            $insertData = [
                'name' => $this->request->getPost('username'),
                'email' => $emailAddr,
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'phone' => $this->request->getPost('phone'),
                'store_name' => $this->request->getPost('store_name'),
                'verification_code' => $verificationCode,
                'code_expires_at' => date('Y-m-d H:i:s', strtotime('+15 minutes')),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $insertId = $this->PendingUsers->insert($insertData);

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
                'redirect' => site_url('vendor/verify?email=' . urlencode($emailAddr))
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
        $user = $this->PendingUsers->where('email', $email)->first();
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
        $this->PendingUsers->update($user['id'], [
            'verification_code' => null,
            'code_expires_at' => null,
            'status' => 'verified'
        ]);

        $newVendor = [
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $user['password'],
            'phone' => $user['phone'],
            'store_name' => $user['store_name'],
            'created_at' => date('Y-m-d H:i:s'),
            'role' => 'vendor'

        ];
        $this->UserModel->insert($newVendor);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Verification successful',
            'redirect' => site_url('vendor/login')
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
        $user = $this->PendingUsers->where('email', $emailAddr)->first();
        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Email not found to resend code please register.'
            ]);
        }
        // Generate verification code
        $verificationCode = random_int(100000, 999999);



        $insertId = $this->PendingUsers->update($user['id'], [
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


        if (empty($password) && empty($newPassword)) {

            return $this->updateProfileAll($userData, '');
        }


        if (!password_verify($password, $userData['password'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Current Password is Wrong.'
            ]);
        }

        return $this->updateProfileAll($userData, $newPassword);


    }

    private function handleImageUpload($file, $column, $userId, $imageId, $inputName)
    {
        if ($file && $file->isValid() && !$file->hasMoved()) {

            $validationRule = [
                $inputName => [
                    'rules' => "is_image[$inputName]|mime_in[$inputName,image/jpg,image/jpeg,image/png]|max_size[$inputName,10240]",
                    'errors' => [
                        'is_image' => ucfirst($column) . ' must be an image',
                        'mime_in' => 'Only JPG, JPEG, PNG files are allowed',
                        'max_size' => ucfirst($column) . ' size should not exceed 10MB',
                    ],
                ],
            ];

            if (!$this->validate($validationRule)) {
                return [
                    'status' => 'error',
                    'message' => implode('<br>', $this->validator->getErrors())
                ];
            }

            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/profile', $newName);
            $filePath = 'uploads/profile/' . $newName;

            $oldImage = $this->Images->where('user_id', $userId)->first();

            if ($oldImage) {
                if (!empty($oldImage[$column]) && file_exists(FCPATH . $oldImage[$column])) {
                    try {
                        unlink(FCPATH . $oldImage[$column]);
                    } catch (\Throwable $e) {
                        log_message('error', 'File delete failed: ' . $e->getMessage());
                    }
                }
                $this->Images->update($oldImage['id'], [
                    $column => $filePath,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                return ['status' => 'success', 'id' => $oldImage['id'], 'path' => $filePath];
            } else {
                $id = $this->Images->insert([
                    'user_id' => $userId,
                    $column => $filePath,
                    'created_at' => date('Y-m-d H:i:s')
                ], true);
                return ['status' => 'success', 'id' => $id, 'path' => $filePath];
            }
        }

        return null;
    }

    private function updateProfileAll($userData, $newPassword)
    {
        $updateData = [
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'store_name' => $this->request->getPost('store_name'),
            'address' => $this->request->getPost('address'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if (!empty($newPassword)) {
            $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        // Handle logo and profile photo
        $logoResult = $this->handleImageUpload(
            $this->request->getFile('vendorFile'),
            'logo_path',
            $userData['id'],
            $userData['image_id'],
            'vendorFile' // ✅ pass input field name
        );

        $profileResult = $this->handleImageUpload(
            $this->request->getFile('vendorProfilePhoto'),
            'profile_path',
            $userData['id'],
            $userData['image_id'],
            'vendorProfilePhoto' // ✅ pass input field name
        );
        if ($logoResult)
            $updateData['image_id'] = $logoResult['id'];
        if ($profileResult)
            $updateData['image_id'] = $profileResult['id'];

        // Final update
        $update = $this->UserModel->update($userData['id'], $updateData);
        return $this->response->setJSON([
            'status' => $update ? 'success' : 'error',
            'message' => $update ? 'Profile updated successfully!' : 'Profile not updated. Try again later.'
        ]);

    }

    // forgot password

    public function forgotPassword()
    {
        $emailAddr = $this->request->getPost('email');
        $user = $this->UserModel->where('email', $emailAddr)->first();
        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Email not registered please register'
            ]);
        }
        // Generate verification code
        $verificationCode = random_int(100000, 999999);

        $data = [
            'email' => $emailAddr,
            'otp' => $verificationCode,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+15 minutes'))
        ];

        $email_check = $this->PasswordReset->where('email', $emailAddr)->first();
        if (!$email_check) {
            $insertId = $this->PasswordReset->insert($data);
        } else {
            $insertId = $this->PasswordReset->update($email_check['id'], $data);
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
            'redirect' => site_url('vendor/reset-verify?email=' . urlencode($emailAddr))
        ]);

    }
    // forgot password code verify

    public function forgotCodeVerify()
    {
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
            'redirect' => site_url('vendor/create-new-password?email=' . urlencode($user['email']))
        ]);
    }
    public function forgotCodeVerifyResend()
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
    public function newPassword()
    {
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
        $insertId = $this->UserModel->update($user['id'], [
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
        if (!$insertId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Password Not updated Please try again'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Password Updated Successfully',
            'redirect' => site_url('vendor/login')
        ]);

    }
}
