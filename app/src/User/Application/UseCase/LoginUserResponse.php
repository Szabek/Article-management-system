<?php

namespace App\User\Application\UseCase;

class LoginUserResponse
{
    public bool $success;
    public string $errorMessage;

    public function __construct(bool $success, string $errorMessage = '')
    {
        $this->success = $success;
        $this->errorMessage = $errorMessage;
    }
}