<?php
namespace App\Models;

use CodeIgniter\Model;

class PasswordReset extends Model
{
    protected $table = 'password_reset';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'email', 'otp','created_at','expires_at','status'
    ];
}
