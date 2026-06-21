<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;
class OfflineSale extends Entity {
    protected array $_accessible = ['recorded_by'=>true,'sale_date'=>true,'total_amount'=>true,'notes'=>true];
}
