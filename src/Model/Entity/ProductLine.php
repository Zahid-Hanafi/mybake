<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;
class ProductLine extends Entity {
    protected array $_accessible = ['name'=>true,'slug'=>true,'description'=>true,'sort_order'=>true];
}
