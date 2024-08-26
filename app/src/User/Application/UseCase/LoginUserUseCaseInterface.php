<?php

namespace App\User\Application\UseCase;

use App\User\Application\Services\PasswordService;

interface LoginUserUseCaseInterface
{
    public function execute(LoginUserRequest $request): LoginUserResponse;
}