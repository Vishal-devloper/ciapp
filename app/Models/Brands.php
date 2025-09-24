<?php
namespace App\Models;

use CodeIgniter\Model;

class Brands extends Model
{
    protected $table = 'brands';
    protected $primaryKey = 'brand_id';
    protected $allowedFields = [
        'name','description','logo','status'
    ];
}
