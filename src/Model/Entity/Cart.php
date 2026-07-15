<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;
class Cart extends Entity {
    protected $_accessible = ['user_id'=>true, 'session_id'=>true];
}
