<?php
namespace App\Controllers\vendor;

use App\Controllers\BaseController;
use App\Models\vendor\UserModel;
use App\Models\vendor\UserVerifyModel;
use App\Models\vendor\StoreLogo;

class User extends BaseController
{
    protected $UserModel;
    protected $UserVerifyModel;
    protected $StoreLogo;

    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->UserVerifyModel = new UserVerifyModel();
        $this->StoreLogo = new StoreLogo();
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
                    'phone' => $this->request->getPost('phone'),
                    'store_name' => $this->request->getPost('store_name'),
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

        $newVendor = [
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $user['password'],
            'phone' => $user['phone'],
            'store_name' => $user['store_name'],
            'created_at' => date('Y-m-d H:i:s')

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
            'isVendorLogin' => true
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Login successful.',
            'redirect' => site_url('vendor/dashboard')
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
            return $this->updateProfileWithoutPassword($userData);
        }


        if (!password_verify($password, $userData['password'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Current Password is Wrong.'
            ]);
        }

        return $this->updateProfileWithPassword($userData, $newPassword);


    }

    private function updateProfileWithoutPassword($userData)
    {
        $img = $this->request->getFile('vendorFile');           // Store logo
        $profileImg = $this->request->getFile('vendorProfilePhoto');   // Profile photo

        // Update basic fields first
        $updateData = [
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'store_name' => $this->request->getPost('store_name'),
            'address' => $this->request->getPost('address'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        /* -------------------------------------------
           STORE LOGO UPLOAD
        ------------------------------------------- */
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $validationRule = [
                'vendorFile' => [
                    'rules' => 'is_image[vendorFile]|mime_in[vendorFile,image/jpg,image/jpeg,image/png]|max_size[vendorFile,10240]',
                    'errors' => [
                        'is_image' => 'File must be an image',
                        'mime_in' => 'Only JPG, JPEG, PNG files are allowed',
                        'max_size' => 'Image size should not exceed 10MB',
                    ],
                ],
            ];

            if (!$this->validate($validationRule)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => implode('<br>', $this->validator->getErrors())
                ]);
            }

            
            $newLogoName = $img->getRandomName();
            $img->move(FCPATH . 'uploads/vendor/logo', $newLogoName);
            $filePath = 'uploads/vendor/logo/' . $newLogoName;

            
            $oldLogo = $this->StoreLogo->where('vendor_id', $userData['id'])->first();

            if ($oldLogo) {
                
                if (!empty($oldLogo['logo_path']) && file_exists(FCPATH . $oldLogo['logo_path'])) {
                    unlink(FCPATH . $oldLogo['logo_path']);
                }

                
                $this->StoreLogo->update($oldLogo['id'], [
                    'logo_path' => $filePath
                ]);
                $logoId = $oldLogo['id'];
            } else {
                
                $logoId = $this->StoreLogo->insert([
                    'vendor_id' => $userData['id'],
                    'logo_path' => $filePath,
                    'created_at' => date('Y-m-d H:i:s')
                ], true); 
            }

            // Update vendor table
            $updateData['store_logo_id'] = $logoId;
        }

        /* -------------------------------------------
           PROFILE PHOTO UPLOAD
        ------------------------------------------- */
        if ($profileImg && $profileImg->isValid() && !$profileImg->hasMoved()) {
            $validationRuleProfile = [
                'vendorProfilePhoto' => [
                    'rules' => 'is_image[vendorProfilePhoto]|mime_in[vendorProfilePhoto,image/jpg,image/jpeg,image/png]|max_size[vendorProfilePhoto,10240]',
                    'errors' => [
                        'is_image' => 'Profile photo must be an image',
                        'mime_in' => 'Only JPG, JPEG, PNG files are allowed',
                        'max_size' => 'Profile photo size should not exceed 10MB',
                    ],
                ],
            ];

            if (!$this->validate($validationRuleProfile)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => implode('<br>', $this->validator->getErrors())
                ]);
            }

            
            $newProfileName = $profileImg->getRandomName();
            $profileImg->move(FCPATH . 'uploads/vendor/logo', $newProfileName);
            $filePath = 'uploads/vendor/logo/' . $newProfileName;

            
            $oldProfile = $this->StoreLogo->where('vendor_id', $userData['id'])->first();

            if ($oldProfile) {
                
                if (!empty($oldProfile['profile_path']) && file_exists(FCPATH . $oldProfile['profile_path'])) {
                    unlink(FCPATH . $oldProfile['profile_path']);
                }

                
                $this->StoreLogo->update($oldProfile['id'], [
                    'profile_path' => $filePath
                ]);
                $logoId = $oldProfile['id'];
            } else {
                
                $logoId = $this->StoreLogo->insert([
                    'vendor_id' => $userData['id'],
                    'profile_path' => $filePath,
                    'created_at' => date('Y-m-d H:i:s')
                ], true); 
            }

            // Update vendor table
            $updateData['profile_img_id'] = $logoId;

        }

        /* -------------------------------------------
           FINAL UPDATE
        ------------------------------------------- */
        $update = $this->UserModel->update($userData['id'], $updateData);

        return $this->response->setJSON([
            'status' => $update ? 'success' : 'error',
            'message' => $update ? 'Profile updated successfully!' : 'Profile not updated. Try again later.'
        ]);
    }
    private function updateProfileWithPassword($userData, $newPassword)
    {
        $img = $this->request->getFile('vendorFile');           // Store logo
        $profileImg = $this->request->getFile('vendorProfilePhoto');   // Profile photo


        $updateData = [
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'store_name' => $this->request->getPost('store_name'),
            'address' => $this->request->getPost('address'),
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        /* -------------------------------------------
           STORE LOGO UPLOAD  (mirrors WithoutPassword)
        ------------------------------------------- */
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $validationRule = [
                'vendorFile' => [
                    'rules' => 'is_image[vendorFile]|mime_in[vendorFile,image/jpg,image/jpeg,image/png]|max_size[vendorFile,10240]',
                    'errors' => [
                        'is_image' => 'File must be an image',
                        'mime_in' => 'Only JPG, JPEG, PNG files are allowed',
                        'max_size' => 'Image size should not exceed 10MB',
                    ],
                ],
            ];

            if (!$this->validate($validationRule)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => implode('<br>', $this->validator->getErrors())
                ]);
            }

            
            $newLogoName = $img->getRandomName();
            $img->move(FCPATH . 'uploads/vendor/logo', $newLogoName);
            $filePath = 'uploads/vendor/logo/' . $newLogoName;

            
            $oldLogo = $this->StoreLogo->where('vendor_id', $userData['id'])->first();

            if ($oldLogo) {
                
                if (!empty($oldLogo['logo_path']) && file_exists(FCPATH . $oldLogo['logo_path'])) {
                    unlink(FCPATH . $oldLogo['logo_path']);
                }

                
                $this->StoreLogo->update($oldLogo['id'], [
                    'logo_path' => $filePath
                ]);
                $logoId = $oldLogo['id'];
            } else {
                
                $logoId = $this->StoreLogo->insert([
                    'vendor_id' => $userData['id'],
                    'logo_path' => $filePath,
                    'created_at' => date('Y-m-d H:i:s')
                ], true); 
            }

            // Update vendor table
            $updateData['store_logo_id'] = $logoId;
        }

        /* -------------------------------------------
           PROFILE PHOTO UPLOAD
        ------------------------------------------- */
        if ($profileImg && $profileImg->isValid() && !$profileImg->hasMoved()) {
            $validationRuleProfile = [
                'vendorProfilePhoto' => [
                    'rules' => 'is_image[vendorProfilePhoto]|mime_in[vendorProfilePhoto,image/jpg,image/jpeg,image/png]|max_size[vendorProfilePhoto,10240]',
                    'errors' => [
                        'is_image' => 'Profile photo must be an image',
                        'mime_in' => 'Only JPG, JPEG, PNG files are allowed',
                        'max_size' => 'Profile photo size should not exceed 10MB',
                    ],
                ],
            ];

            if (!$this->validate($validationRuleProfile)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => implode('<br>', $this->validator->getErrors())
                ]);
            }

            
            $newProfileName = $profileImg->getRandomName();
            $profileImg->move(FCPATH . 'uploads/vendor/logo', $newProfileName);
            $filePath = 'uploads/vendor/logo/' . $newProfileName;

            
            $oldProfile = $this->StoreLogo->where('vendor_id', $userData['id'])->first();

            if ($oldProfile) {
                
                if (!empty($oldProfile['profile_path']) && file_exists(FCPATH . $oldProfile['profile_path'])) {
                    unlink(FCPATH . $oldProfile['profile_path']);
                }

                
                $this->StoreLogo->update($oldProfile['id'], [
                    'profile_path' => $filePath
                ]);
                $logoId = $oldProfile['id'];
            } else {
                
                $logoId = $this->StoreLogo->insert([
                    'vendor_id' => $userData['id'],
                    'profile_path' => $filePath,
                    'created_at' => date('Y-m-d H:i:s')
                ], true); 
            }

            // Update vendor table
            $updateData['profile_img_id'] = $logoId;

        }

        /* -------------------------------------------
           FINAL UPDATE
        ------------------------------------------- */
        $update = $this->UserModel->update($userData['id'], $updateData);

        return $this->response->setJSON([
            'status' => $update ? 'success' : 'error',
            'message' => $update ? 'Profile updated successfully!' : 'Profile not updated. Try again later.'
        ]);
    }


}
