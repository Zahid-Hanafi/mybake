<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

class User extends Entity
{
    protected $_accessible = [
        'first_name'  => true,
        'last_name'   => true,
        'email'       => true,
        'phone_no'    => true,
        'password'    => true,
        'role'        => true,
        'status'      => true,
        'created_at'  => true,
        'modified'    => true,
    ];

    protected $_hidden = ['password'];

    // Auto-hash password on set
    protected function _setPassword(string $password): string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
        return $password;
    }

    // Virtual: full_name helper
    protected function _getFullName(): string
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }
}