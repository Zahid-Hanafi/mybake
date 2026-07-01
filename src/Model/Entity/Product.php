<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;
class Product extends Entity {
    protected $_accessible = [
        'product_line_id'=>true,'name'=>true,'description'=>true,'price'=>true,
        'stock_quantity'=>true,'image'=>true,'is_new_arrival'=>true,
        'is_best_seller'=>true,'status'=>true,
    ];
}
