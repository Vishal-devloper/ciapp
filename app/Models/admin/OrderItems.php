<?php
namespace App\Models;

use CodeIgniter\Model;

class OrderItems extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'item_id';
    protected $allowedFields = [
        'order_id',	'product_id',	'vendor_id',	'quantity'	,'price'	
    ];
}
