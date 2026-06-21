<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;
class Testimonial extends Entity {
    protected array $_accessible = ['author_name'=>true,'content'=>true,'rating'=>true,'is_active'=>true,'sort_order'=>true];
}
