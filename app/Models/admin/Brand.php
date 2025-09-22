<?php
namespace App\Models\admin;

use CodeIgniter\Model;

class Brand extends Model
{
    protected $table = 'brands';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'vendor_id', 'profile_path','logo_path','created_at'
    ];
}
