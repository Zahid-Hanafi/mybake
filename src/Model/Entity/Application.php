<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Application Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $cgpa
 * @property int $semester
 * @property string $gender
 * @property string $home_address
 * @property string $achievement
 * @property string|null $relative_experience
 * @property int|null $interview_slot_id
 * @property string|null $status
 * @property string|null $rejection_reason
 * @property \Cake\I18n\FrozenTime|null $created_at
 * @property \Cake\I18n\FrozenTime|null $modified_at
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\InterviewSlot $interview_slot
 */
class Application extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'user_id' => true,
        'cgpa' => true,
        'semester' => true,
        'gender' => true,
        'home_address' => true,
        'achievement' => true,
        'relative_experience' => true,
        'interview_slot_id' => true,
        'status' => true,
        'rejection_reason' => true,
        'created_at' => true,
        'modified_at' => true,
        'user' => true,
        'interview_slot' => true,
    ];
}
