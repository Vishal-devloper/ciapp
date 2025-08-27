<?php
namespace App\Models\admin;

use CodeIgniter\Model;

class StoreLogo extends Model
{
    protected $table = 'vendor_images';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'vendor_id', 'profile_path','logo_path','created_at'
    ];
}
