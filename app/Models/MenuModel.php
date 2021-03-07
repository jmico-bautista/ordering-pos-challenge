<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model {
    protected $table = 'menu';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType  = 'array';
}

?>