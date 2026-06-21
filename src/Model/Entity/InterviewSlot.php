<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InterviewSlot Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $interview_date
 * @property string $slot_time
 * @property bool $is_booked
 * @property \Cake\I18n\FrozenTime|null $created_at
 * @property \Cake\I18n\FrozenTime|null $modified_at
 *
 * @property \App\Model\Entity\Application[] $applications
 */
class InterviewSlot extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'interview_date' => true,
        'slot_time' => true,
        'is_booked' => true,
        'created_at' => true,
        'modified_at' => true,
    ];
}
