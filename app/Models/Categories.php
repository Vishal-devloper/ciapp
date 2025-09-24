<?php
namespace App\Models;

use CodeIgniter\Model;

class categories extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    protected $allowedFields = [
         'name','description','status','created_at','updated_at'
    ];
}
