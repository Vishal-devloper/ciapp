<?php
namespace App\Models\admin;

use CodeIgniter\Model;

class UserVerifyModel extends Model
{
    protected $table = 'pending_admins';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'email','password','verification_code','code_expires_at','created_at','status'
    ];
}
