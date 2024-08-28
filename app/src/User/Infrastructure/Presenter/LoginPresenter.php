<?php

namespace App\User\Infrastructure\Presenter;

use App\User\Application\UseCase\Login\LoginUserResponse;
use App\User\Infrastructure\LoginPresenterInterface;
use Twig\Environment;

class LoginPresenter implements LoginPresenterInterface
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function present(LoginUserResponse $response): string
    {
        $viewModel = new LoginViewModel();

        if (!$response->success) {
            $viewModel->error = $response->errorMessage;
        }

        return $this->twig->render('user/login.html.twig', [
            'viewModel' => $viewModel,
        ]);
    }
}