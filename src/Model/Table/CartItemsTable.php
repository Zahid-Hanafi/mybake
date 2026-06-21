<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class CartItemsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('cart_items');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Carts',    ['foreignKey' => 'cart_id']);
        $this->belongsTo('Products', ['foreignKey' => 'product_id']);
    }
}
