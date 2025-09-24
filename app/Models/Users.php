<?php
namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
    'name', 
    'email',
    'password',
    'phone',
    'address',
    'image_id',
    'role',           // new field to identify admin/vendor/user
    'status',
    'store_name',     // vendor-specific // vendor-specific
    'created_at',
    'updated_at'
];
}
