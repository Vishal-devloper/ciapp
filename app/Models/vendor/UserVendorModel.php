<?php
namespace App\Models\vendor;

use CodeIgniter\Model;

class UserVendorModel extends Model
{
    protected $table = 'vendors';
    protected $primaryKey = 'vendor_id';
    protected $allowedFields = [
        'username', 'email','password','phone',	'store_name',	'store_logo',	'address',	'status',	'created_at','updated_at'
    ];
}
