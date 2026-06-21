<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InterviewSlots Model
 *
 * @property \App\Model\Table\ApplicationsTable&\Cake\ORM\Association\HasMany $Applications
 *
 * @method \App\Model\Entity\InterviewSlot newEmptyEntity()
 * @method \App\Model\Entity\InterviewSlot newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\InterviewSlot[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InterviewSlot get($primaryKey, $options = [])
 * @method \App\Model\Entity\InterviewSlot findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\InterviewSlot patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InterviewSlot[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\InterviewSlot|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InterviewSlot saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 */
class InterviewSlotsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('interview_slots');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Applications', [
            'foreignKey' => 'interview_slot_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->date('interview_date')
            ->requirePresence('interview_date', 'create')
            ->notEmptyDate('interview_date')
            ->add('interview_date', 'validDay', [
                'rule' => function ($value) {
                    // Handle both string and object inputs
                    if (is_string($value)) {
                        $date = new \DateTime($value);
                    } else {
                        $date = $value;
                    }
                    $dayOfWeek = (int)$date->format('N');
                    // 1 = Monday, 2 = Tuesday, 3 = Wednesday
                    return in_array($dayOfWeek, [1, 2, 3]);
                },
                'message' => 'Interview date must be Monday, Tuesday, or Wednesday'
            ]);

        $validator
            ->scalar('slot_time')
            ->requirePresence('slot_time', 'create')
            ->notEmptyString('slot_time')
            ->inList('slot_time', ['8pm-9pm', '9pm-10pm'], 'Invalid time slot');

        $validator
            ->boolean('is_booked')
            ->notEmptyString('is_booked');

        return $validator;
    }

    /**
     * Find available (unbooked) slots
     */
    public function findAvailable(Query $query, array $options): Query
    {
        return $query
            ->where(['InterviewSlots.is_booked' => false])
            ->where(['InterviewSlots.interview_date >=' => date('Y-m-d')])
            ->order(['InterviewSlots.interview_date' => 'ASC', 'InterviewSlots.slot_time' => 'ASC']);
    }
}
