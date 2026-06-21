<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class OfflineSalesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('offline_sales');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Users',            ['foreignKey' => 'recorded_by']);
        $this->hasMany('OfflineSaleItems',   ['foreignKey' => 'offline_sale_id', 'dependent' => true]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->date('sale_date')->notEmptyString('sale_date');
        $validator->decimal('total_amount');
        return $validator;
    }
}
