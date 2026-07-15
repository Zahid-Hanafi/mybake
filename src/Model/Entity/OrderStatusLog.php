<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;

class OrderStatusLog extends Entity
{
    protected $_accessible = [
        'order_id' => true,
        'status' => true,
        'note' => true,
        'created_by' => true,
    ];
}
