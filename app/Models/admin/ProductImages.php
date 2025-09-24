<?php
namespace App\Models;

use CodeIgniter\Model;

class ProductImages extends Model
{
    protected $table = 'product_images';
    protected $primaryKey = 'image_id';
    protected $allowedFields = [ 
     'product_id',	'image_path1',	'image_path2',	'image_path3',	'image_path4',	'image_path5',	'image_path6',	
    ];
}
