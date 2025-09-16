<?php
namespace App\Models\admin;

use CodeIgniter\Model;

class PasswordReset extends Model
{
    protected $table = 'password_reset';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'email', 'otp','created_at','expires_at','status'
    ];
}
