<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProductsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('products');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('ProductLines', ['foreignKey' => 'product_line_id']);
        $this->hasMany('CartItems',      ['foreignKey' => 'product_id']);
        $this->hasMany('OrderItems',     ['foreignKey' => 'product_id']);
        $this->hasMany('OfflineSaleItems', ['foreignKey' => 'product_id']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('name');
        $validator->decimal('price');
        $validator->integer('stock_quantity');
        $validator->notEmptyString('status');
        return $validator;
    }
}
