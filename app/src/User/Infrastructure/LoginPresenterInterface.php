<?php

namespace App\User\Infrastructure;

use App\User\Application\UseCase\Login\LoginUserResponse;

interface LoginPresenterInterface
{
    public function present(LoginUserResponse $response): string;
}