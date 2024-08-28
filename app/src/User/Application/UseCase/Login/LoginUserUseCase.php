<?php

namespace App\User\Application\UseCase\Login;

use App\User\Application\Services\PasswordChecker;
use App\User\Domain\Repository\UserRepositoryInterface;

class LoginUserUseCase implements LoginUserUseCaseInterface
{
    private UserRepositoryInterface $userRepository;
    private PasswordChecker $passwordChecker;

    public function __construct(UserRepositoryInterface $userRepository, PasswordChecker $passwordChecker)
    {
        $this->userRepository = $userRepository;
        $this->passwordChecker = $passwordChecker;
    }

    public function execute(LoginUserRequest $request): LoginUserResponse
    {
        $user = $this->userRepository->findByUsername($request->username);

        if ($user && $this->passwordChecker->verifyPassword($request->password, $user->getPassword())) {
            return new LoginUserResponse(true);
        }

        return new LoginUserResponse(false, 'Invalid credentials');
    }
}