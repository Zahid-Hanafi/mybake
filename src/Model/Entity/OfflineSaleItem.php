<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;
class OfflineSaleItem extends Entity {
    protected $_accessible = ['offline_sale_id'=>true,'product_id'=>true,'product_name'=>true,'unit_price'=>true,'quantity'=>true,'subtotal'=>true];
}
