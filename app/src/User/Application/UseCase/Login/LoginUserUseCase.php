<?php

namespace App\User\Application\UseCase\Login;

use App\User\Application\Services\PasswordService;
use App\User\Domain\Repository\UserRepositoryInterface;

class LoginUserUseCase implements LoginUserUseCaseInterface
{
    private UserRepositoryInterface $userRepository;
    private PasswordService $passwordService;

    public function __construct(UserRepositoryInterface $userRepository, PasswordService $passwordService)
    {
        $this->userRepository = $userRepository;
        $this->passwordService = $passwordService;
    }

    public function execute(LoginUserRequest $request): LoginUserResponse
    {
        $user = $this->userRepository->findByUsername($request->username);

        if ($user && $this->passwordService->verifyPassword($request->password, $user->getPassword())) {
            return new LoginUserResponse(true);
        }

        return new LoginUserResponse(false, 'Invalid credentials');
    }
}