<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProgramsFixture
 */
class ProgramsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'venue' => 'Lorem ipsum dolor sit amet',
                'date' => '2026-01-11',
                'google_event_id' => 'Lorem ipsum dolor sit amet',
                'created_by' => 1,
                'status' => 'Lorem ipsum dolor sit amet',
                'created_at' => 1768141336,
                'modified_at' => 1768141336,
            ],
        ];
        parent::init();
    }
}
