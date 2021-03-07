<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuCategoriesModel extends Model {
    protected $table = 'menu_categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType  = 'array';
}

?>