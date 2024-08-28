<?php

namespace App\User\Domain;

interface PasswordHasherInterface
{
    public function hashPassword(string $password): string;
}