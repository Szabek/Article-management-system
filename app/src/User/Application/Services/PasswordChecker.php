<?php

namespace App\User\Application\Services;

class PasswordChecker
{
    public function verifyPassword(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }
}