<?php
namespace App\Models\vendor;

use CodeIgniter\Model;

class UserVerifyModel extends Model
{
    protected $table = 'pending_vendors';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'email','password','phone',	'store_name','verification_code','code_expires_at'
    ];
}
