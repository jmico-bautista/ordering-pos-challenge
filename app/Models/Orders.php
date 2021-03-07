<?php

namespace App\Models;

use CodeIgniter\Model;

class Orders extends Model {
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType  = 'array';
    protected $allowedFields = ['name', 'total', 'coupon_id'];
}

?>