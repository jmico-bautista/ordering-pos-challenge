<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdersProductsRef extends Model {
    protected $table = 'orders_products_ref';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType  = 'array';
    protected $allowedFields = ['order_id', 'product_id'];
}

?>