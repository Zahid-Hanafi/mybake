<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Program Entity
 *
 * @property int $id
 * @property string $name
 * @property string $venue
 * @property \Cake\I18n\FrozenDate $date
 * @property string|null $description
 * @property string|null $google_event_id
 * @property string|null $google_form_url
 * @property int $created_by
 * @property string|null $status
 * @property \Cake\I18n\FrozenTime|null $created_at
 * @property \Cake\I18n\FrozenTime|null $modified_at
 */
class Program extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'name' => true,
        'venue' => true,
        'date' => true,
        'description' => true,
        'google_event_id' => true,
        'google_form_url' => true,
        'created_by' => true,
        'status' => true,
        'created_at' => true,
        'modified_at' => true,
    ];
}
