<?php
namespace App\Models;

use CodeIgniter\Model;

class Images extends Model
{
    protected $table = 'images';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'profile_path','logo_path','created_at','updated_at'
    ];
}
