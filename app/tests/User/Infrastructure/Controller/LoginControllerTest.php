<?php

use App\User\Application\UseCase\Login\LoginUserRequest;
use App\User\Application\UseCase\Login\LoginUserResponse;
use App\User\Application\UseCase\Login\LoginUserUseCaseInterface;
use App\User\Infrastructure\Controller\LoginController;
use App\User\Infrastructure\LoginPresenterInterface;
use PHPUnit\Framework\TestCase;
use Szabek\Framework\Http\Request;
use Szabek\Framework\Http\Response;

class LoginControllerTest extends TestCase
{
    private $loginUserUseCase;
    private $presenter;
    private $controller;

    protected function setUp(): void
    {
        $this->loginUserUseCase = $this->createMock(LoginUserUseCaseInterface::class);
        $this->presenter = $this->createMock(LoginPresenterInterface::class);
        $this->controller = new LoginController($this->loginUserUseCase, $this->presenter);

        // Start the session for testing purposes
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public function testIndex()
    {
        $this->presenter->expects($this->once())
            ->method('present')
            ->with($this->isInstanceOf(LoginUserResponse::class))
            ->willReturn('Rendered content');

        $response = $this->controller->index();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('Rendered content', $response->getContent());
    }

    public function testSuccessfulLogin()
    {
        $request = new Request([], ['username' => 'validUser', 'password' => 'correctPassword'], [], [], []);
        $loginResponse = new LoginUserResponse(true);

        $this->loginUserUseCase->expects($this->once())
            ->method('execute')
            ->with($this->isInstanceOf(LoginUserRequest::class))
            ->willReturn($loginResponse);

        $response = $this->controller->login($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(302, $response->getStatus());
        $this->assertEquals('/articles', $response->getHeaders()['Location']);
        $this->assertEquals('validUser', $_SESSION['user']);
    }

    public function testFailedLogin()
    {
        $request = new Request([], ['username' => 'invalidUser', 'password' => 'wrongPassword'], [], [], []);
        $loginResponse = new LoginUserResponse(false, 'Invalid credentials');

        $this->loginUserUseCase->expects($this->once())
            ->method('execute')
            ->with($this->isInstanceOf(LoginUserRequest::class))
            ->willReturn($loginResponse);

        $this->presenter->expects($this->once())
            ->method('present')
            ->with($loginResponse)
            ->willReturn('Rendered error content');

        $response = $this->controller->login($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(401, $response->getStatus());
        $this->assertEquals('Rendered error content', $response->getContent());
    }
}