<?php

namespace App\User\Infrastructure\Hasher;

use App\User\Domain\PasswordHasherInterface;

class PasswordHasher implements PasswordHasherInterface
{
    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}