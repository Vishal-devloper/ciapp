<?php
namespace App\Models\admin;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'email','password'
    ];
}
