<?php

namespace App\Models;

use CodeIgniter\Model;

class E_admin_model extends Model
{
    protected $table = 'products';       // Your table name
    protected $primaryKey = 'id';        // Your table's primary key

    protected $allowedFields = [
        'name', 'description', 'price', 'stock', 'category_id', 'brand_id', 'vendor_id', 'status', 'image'
    ];
}