<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
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
                'full_name' => 'Lorem ipsum dolor sit amet',
                'matric_no' => 'Lorem ipsum dolor ',
                'email' => 'Lorem ipsum dolor sit amet',
                'phone_no' => 'Lorem ipsum d',
                'password' => 'Lorem ipsum dolor sit amet',
                'role' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
                'created_at' => 1768141236,
                'modified_at' => 1768141236,
            ],
        ];
        parent::init();
    }
}
