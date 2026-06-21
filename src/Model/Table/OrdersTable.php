<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class OrdersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('orders');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Users',      ['foreignKey' => 'user_id']);
        $this->hasMany('OrderItems',   ['foreignKey' => 'order_id', 'dependent' => true]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('delivery_address');
        $validator->notEmptyString('phone_no');
        $validator->decimal('total_amount');
        return $validator;
    }
}
