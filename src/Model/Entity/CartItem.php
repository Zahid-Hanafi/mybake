<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;
class CartItem extends Entity {
    protected array $_accessible = ['cart_id'=>true,'product_id'=>true,'quantity'=>true];
}
