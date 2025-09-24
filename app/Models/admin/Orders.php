<?php
namespace App\Models;

use CodeIgniter\Model;

class Orders extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    protected $allowedFields = [
         	'user_id',	'total_amount',	'payment_method',	'payment_status',	'order_status',	'shipping_address',	'created_at',	'updated_at'	
    ];
}
