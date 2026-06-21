<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AddressesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('addresses');
        $this->setDisplayField('address_line');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Users', ['foreignKey' => 'user_id']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('address_line');
        $validator->notEmptyString('city');
        $validator->notEmptyString('state');
        $validator->notEmptyString('postal_code');
        return $validator;
    }
}
