<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class CartsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('carts');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', ['foreignKey' => 'user_id']);
        $this->hasMany('CartItems', ['foreignKey' => 'cart_id', 'dependent' => true]);
    }
}
