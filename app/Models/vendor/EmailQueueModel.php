<?php
namespace App\Models\vendor;

use CodeIgniter\Model;

class EmailQueueModel extends Model
{
    protected $table = 'email_queue';
    protected $primaryKey = 'id';
    protected $allowedFields = ['to_email', 'subject', 'message', 'status', 'created_at', 'sent_at'];
}
