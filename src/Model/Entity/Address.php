<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;
class Address extends Entity {
    protected array $_accessible = [
        'user_id'=>true,'address_line'=>true,'unit_no'=>true,
        'city'=>true,'state'=>true,'postal_code'=>true,'label'=>true,'is_default'=>true,
    ];
}
