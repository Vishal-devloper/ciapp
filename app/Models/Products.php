<?php
namespace App\Models;

use CodeIgniter\Model;

class Products extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $allowedFields = [ 
     'vendor_id',	'category_id',	'subcategory_id',	'brand_id',	'name',	'slug',	'description',	'price',	'discount_price',	'stock',	'product_image_id',	'status',	'created_at',	'updated_at'	

    ];
}
