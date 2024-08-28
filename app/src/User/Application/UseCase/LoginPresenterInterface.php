<?php

namespace App\User\Application\UseCase;

interface LoginPresenterInterface
{
    public function present(LoginUserResponse $response): string;
}