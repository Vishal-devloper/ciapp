<?php
namespace App\Models;

use CodeIgniter\Model;

class SubCategories extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'id';
    protected $allowedFields = [ 
     	'category_id', 'name', 'description', 'status', 'created_at','updated_at'
	
    ];
}
