<?php

namespace App\Models;

use CodeIgniter\Model;

class Products extends Model {
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType  = 'array';
    protected $allowedFields = ['product_id', 'quantity', 'sub_total'];
}

?>