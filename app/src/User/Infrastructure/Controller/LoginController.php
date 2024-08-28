<?php

namespace App\User\Infrastructure\Controller;

use App\User\Application\UseCase\LoginPresenterInterface;
use App\User\Application\UseCase\LoginUserRequest;
use App\User\Application\UseCase\LoginUserResponse;
use App\User\Application\UseCase\LoginUserUseCase;
use App\User\Application\UseCase\LoginUserUseCaseInterface;
use App\User\Infrastructure\Presenter\LoginPresenter;
use App\User\Infrastructure\Presenter\LoginViewModel;
use Szabek\Framework\Http\Request;
use Szabek\Framework\Http\Response;

class LoginController
{
    private LoginUserUseCaseInterface $loginUserUseCase;
    private LoginPresenterInterface $presenter;

    public function __construct(LoginUserUseCaseInterface $loginUserUseCase, LoginPresenterInterface $presenter)
    {
        $this->loginUserUseCase = $loginUserUseCase;
        $this->presenter = $presenter;
    }

    public function index(): Response
    {
        $response = new LoginUserResponse(false);

        $content = $this->presenter->present($response);

        return new Response($content);
    }

    public function login(Request $request): Response
    {
        $loginRequest = new LoginUserRequest(
            $request->postParams['username'] ?? '',
            $request->postParams['password'] ?? ''
        );

        $response = $this->loginUserUseCase->execute($loginRequest);

        if ($response->success) {
            $_SESSION['user'] = $loginRequest->username;
            return new Response('Logged in successfully', 302, ['Location' => '/articles']);
        }

        $content = $this->presenter->present($response);
        return new Response($content, 401);
    }

    public function logout(): Response
    {
        unset($_SESSION['user']);

        session_destroy();

        return new Response(json_encode(['message' => 'Logged out successfully']), 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}