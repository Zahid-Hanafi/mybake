<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('first_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Addresses',    ['foreignKey' => 'user_id', 'dependent' => true]);
        $this->hasOne('Carts',         ['foreignKey' => 'user_id', 'dependent' => true]);
        $this->hasMany('Orders',       ['foreignKey' => 'user_id', 'dependent' => true]);
        $this->hasMany('OfflineSales', ['foreignKey' => 'recorded_by']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 100)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 100)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('phone_no')
            ->maxLength('phone_no', 20)
            ->requirePresence('phone_no', 'create')
            ->notEmptyString('phone_no');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password')
            ->add('password', 'minLength', [
                'rule'    => ['minLength', 8],
                'message' => 'Password must be at least 8 characters long',
            ])
            ->add('password', 'hasUppercase', [
                'rule'    => function ($value) { return (bool)preg_match('/[A-Z]/', $value); },
                'message' => 'Password must contain at least 1 uppercase letter',
            ])
            ->add('password', 'hasNumber', [
                'rule'    => function ($value) { return (bool)preg_match('/[0-9]/', $value); },
                'message' => 'Password must contain at least 1 number',
            ])
            ->add('password', 'hasSymbol', [
                'rule'    => function ($value) { return (bool)preg_match('/[!@#$%^&*()_+\-=\[\]{}|;:,.<>?]/', $value); },
                'message' => 'Password must contain at least 1 symbol',
            ]);

        return $validator;
    }

    public function validationProfile(Validator $validator): Validator
    {
        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 100)
            ->notEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 100)
            ->notEmptyString('last_name');

        $validator
            ->scalar('phone_no')
            ->maxLength('phone_no', 20)
            ->notEmptyString('phone_no');

        // Password optional on update
        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->allowEmptyString('password')
            ->add('password', 'minLength', [
                'rule'    => ['minLength', 8],
                'message' => 'Password must be at least 8 characters long',
                'on'      => function ($context) { return !empty($context['data']['password']); },
            ])
            ->add('password', 'hasUppercase', [
                'rule'    => function ($value) { return empty($value) || (bool)preg_match('/[A-Z]/', $value); },
                'message' => 'Password must contain at least 1 uppercase letter',
            ])
            ->add('password', 'hasNumber', [
                'rule'    => function ($value) { return empty($value) || (bool)preg_match('/[0-9]/', $value); },
                'message' => 'Password must contain at least 1 number',
            ])
            ->add('password', 'hasSymbol', [
                'rule'    => function ($value) { return empty($value) || (bool)preg_match('/[!@#$%^&*()_+\-=\[\]{}|;:,.<>?]/', $value); },
                'message' => 'Password must contain at least 1 symbol',
            ]);

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        return $rules;
    }
}
