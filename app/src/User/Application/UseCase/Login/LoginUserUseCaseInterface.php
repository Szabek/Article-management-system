<?php

namespace App\User\Application\UseCase\Login;

interface LoginUserUseCaseInterface
{
    public function execute(LoginUserRequest $request): LoginUserResponse;
}