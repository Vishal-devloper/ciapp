<?php
namespace App\Models\admin;

use CodeIgniter\Model;

class ShopAdminModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'description', 'price', 'stock', 'category_id', 'brand_id', 'vendor_id', 'status', 'image'
    ];
}
