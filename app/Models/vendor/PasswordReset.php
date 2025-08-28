<?php
namespace App\Models\vendor;

use CodeIgniter\Model;

class PasswordReset extends Model
{
    protected $table = 'vendor_password_reset';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'email', 'otp','created_at','expires_at','status'
    ];
}
