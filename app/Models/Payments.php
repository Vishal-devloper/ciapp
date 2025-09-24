<?php
namespace App\Models;

use CodeIgniter\Model;

class Payments extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'payment_id';
    protected $allowedFields = [
        'order_id',	'payment_method',	'amount',	'payment_status'	,'transaction_id'	,'paid_at'	

    ];
}
