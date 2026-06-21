<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProductLinesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('product_lines');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasMany('Products', ['foreignKey' => 'product_line_id', 'dependent' => true]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('name');
        $validator->notEmptyString('slug');
        return $validator;
    }
}
