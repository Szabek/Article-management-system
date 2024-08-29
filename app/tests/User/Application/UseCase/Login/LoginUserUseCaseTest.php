<?php

use App\User\Application\Services\PasswordChecker;
use App\User\Application\UseCase\Login\LoginUserRequest;
use App\User\Application\UseCase\Login\LoginUserUseCase;
use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class LoginUserUseCaseTest extends TestCase
{
    private $userRepository;
    private $passwordChecker;
    private $loginUserUseCase;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->passwordChecker = $this->createMock(PasswordChecker::class);
        $this->loginUserUseCase = new LoginUserUseCase($this->userRepository, $this->passwordChecker);
    }

    public function testSuccessfulLogin()
    {
        $request = new LoginUserRequest('validUser', 'correctPassword');
        $user = $this->createMock(User::class);

        $user->method('getPassword')->willReturn('hashedPassword');

        $this->userRepository->expects($this->once())
            ->method('findByUsername')
            ->with('validUser')
            ->willReturn($user);

        $this->passwordChecker->expects($this->once())
            ->method('verifyPassword')
            ->with('correctPassword', 'hashedPassword')
            ->willReturn(true);

        $response = $this->loginUserUseCase->execute($request);

        $this->assertTrue($response->success);
        $this->assertEmpty($response->errorMessage);
    }

    public function testFailedLoginUserNotFound()
    {
        $request = new LoginUserRequest('invalidUser', 'password');

        $this->userRepository->expects($this->once())
            ->method('findByUsername')
            ->with('invalidUser')
            ->willReturn(null);

        $this->passwordChecker->expects($this->never())
            ->method('verifyPassword');

        $response = $this->loginUserUseCase->execute($request);

        $this->assertFalse($response->success);
        $this->assertEquals('Invalid credentials', $response->errorMessage);
    }

    public function testFailedLoginIncorrectPassword()
    {
        $request = new LoginUserRequest('validUser', 'wrongPassword');
        $user = $this->createMock(User::class);

        $user->method('getPassword')->willReturn('hashedPassword');

        $this->userRepository->expects($this->once())
            ->method('findByUsername')
            ->with('validUser')
            ->willReturn($user);

        $this->passwordChecker->expects($this->once())
            ->method('verifyPassword')
            ->with('wrongPassword', 'hashedPassword')
            ->willReturn(false);

        $response = $this->loginUserUseCase->execute($request);

        $this->assertFalse($response->success);
        $this->assertEquals('Invalid credentials', $response->errorMessage);
    }
}