<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class OrderStatusLogsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('order_status_logs');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', ['foreignKey' => 'order_id']);
        $this->belongsTo('Users', ['foreignKey' => 'created_by']);
    }
}
