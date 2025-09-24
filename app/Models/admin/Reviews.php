<?php
namespace App\Models;

use CodeIgniter\Model;

class Reviews extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'review_id';
    protected $allowedFields = [ 
     	'user_id',	'product_id',	'rating',	'comment',	'created_at', 'updated_at'	
    ];
}
