<?php

namespace App\User\Presentation;

class LoginViewModel
{
    public string $username = '';
    public string $error = '';

    public function __construct(string $username = '', string $error = '')
    {
        $this->username = $username;
        $this->error = $error;
    }
}