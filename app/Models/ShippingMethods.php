<?php
namespace App\Models;

use CodeIgniter\Model;

class ShippingMethods extends Model
{
    protected $table = 'shipping_methods';
    protected $primaryKey = 'method_id';
    protected $allowedFields = [ 
     	'name',	'charge',	'estimated_days'	
    ];
}
