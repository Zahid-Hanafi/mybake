<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;
class Promotion extends Entity {
    protected $_accessible = ['message'=>true,'is_active'=>true,'sort_order'=>true];
}
