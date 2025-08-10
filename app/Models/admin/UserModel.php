<?php
namespace App\Models\admin;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'admin_id';
    protected $allowedFields = [
        'username', 'email','password'
    ];
}
