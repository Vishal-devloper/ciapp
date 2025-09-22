<?php
namespace App\Models\vendor;

use CodeIgniter\Model;

class ProfileImg extends Model
{
    protected $table = 'images';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'profile_path','logo_path','created_at'
    ];
}
