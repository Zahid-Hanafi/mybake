<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;
class Order extends Entity {
    protected $_accessible = [
        'user_id'=>true,'address_id'=>true,'delivery_address'=>true,
        'phone_no'=>true,'total_amount'=>true,'status'=>true,'notes'=>true,
        'discount'=>true,'delivery_fee'=>true,
        'qr_token'=>true,'courier_name'=>true,'tracking_number'=>true,
        'shipped_at'=>true,'completed_at'=>true,
    ];
}
