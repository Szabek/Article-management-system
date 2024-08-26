<?php

namespace App\User\Domain\Entity;

class User
{
    private ?int $id;
    private string $username;
    private string $password;

    public function __construct(string $username, string $password, ?int $id = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}