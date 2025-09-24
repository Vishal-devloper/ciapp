<?php
namespace App\Models;

use CodeIgniter\Model;

class Wishlists extends Model
{
    protected $table = 'wishlists';
    protected $primaryKey = 'wishlist_id';
    protected $allowedFields = [ 
     	'user_id',	'product_id'
    ];
}
