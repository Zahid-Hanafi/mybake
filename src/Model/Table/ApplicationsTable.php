<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Applications Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\InterviewSlotsTable&\Cake\ORM\Association\BelongsTo $InterviewSlots
 *
 * @method \App\Model\Entity\Application newEmptyEntity()
 * @method \App\Model\Entity\Application newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Application[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Application get($primaryKey, $options = [])
 * @method \App\Model\Entity\Application findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Application patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Application[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Application|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Application saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 */
class ApplicationsTable extends Table
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

        $this->setTable('applications');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('InterviewSlots', [
            'foreignKey' => 'interview_slot_id',
            'joinType' => 'LEFT',
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
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->decimal('cgpa')
            ->requirePresence('cgpa', 'create')
            ->notEmptyString('cgpa')
            ->range('cgpa', [0, 4], 'CGPA must be between 0 and 4');

        $validator
            ->integer('semester')
            ->requirePresence('semester', 'create')
            ->notEmptyString('semester')
            ->range('semester', [1, 4], 'Only semester 1-4 students can apply');

        $validator
            ->scalar('gender')
            ->requirePresence('gender', 'create')
            ->notEmptyString('gender')
            ->inList('gender', ['Male', 'Female'], 'Please select a valid gender');

        $validator
            ->scalar('home_address')
            ->requirePresence('home_address', 'create')
            ->notEmptyString('home_address');

        $validator
            ->scalar('achievement')
            ->requirePresence('achievement', 'create')
            ->notEmptyString('achievement');

        $validator
            ->scalar('relative_experience')
            ->allowEmptyString('relative_experience');

        $validator
            ->integer('interview_slot_id')
            ->requirePresence('interview_slot_id', 'create')
            ->notEmptyString('interview_slot_id', 'Please select an interview slot');

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

        $validator
            ->scalar('rejection_reason')
            ->allowEmptyString('rejection_reason');

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at');

        $validator
            ->dateTime('modified_at')
            ->allowEmptyDateTime('modified_at');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn('interview_slot_id', 'InterviewSlots'), ['errorField' => 'interview_slot_id']);

        return $rules;
    }

    /**
     * Custom finder to filter by gender
     */
    public function findByGender(Query $query, array $options): Query
    {
        if (!empty($options['gender'])) {
            $query->where(['Applications.gender' => $options['gender']]);
        }
        return $query;
    }

    /**
     * Custom finder to sort by CGPA (highest first)
     */
    public function findSortedByCgpa(Query $query, array $options): Query
    {
        return $query->order(['Applications.cgpa' => 'DESC']);
    }

    /**
     * Custom finder to sort by semester
     */
    public function findSortedBySemester(Query $query, array $options): Query
    {
        return $query->order(['Applications.semester' => 'ASC']);
    }
}
