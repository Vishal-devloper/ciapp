<?php
namespace App\Models;

use CodeIgniter\Model;

class Carts extends Model
{
    protected $table = 'carts';
    protected $primaryKey = 'cart_id';
    protected $allowedFields = [
         'user_id','product_id','quantity','created_at','updated_at'
    ];
}
