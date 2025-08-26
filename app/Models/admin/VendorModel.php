<?php
namespace App\Models\admin;

use CodeIgniter\Model;

class VendorModel extends Model
{
    protected $table = 'vendors';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'email','password','phone',	'store_name','profile_img_id',	'store_logo_id',	'address',	'status',	'created_at','updated_at'
    ];
}
