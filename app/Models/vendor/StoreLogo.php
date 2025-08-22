<?php
namespace App\Models\vendor;

use CodeIgniter\Model;

class StoreLogo extends Model
{
    protected $table = 'vendor_images';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'vendor_id', 'image_path','created_at'
    ];
}
