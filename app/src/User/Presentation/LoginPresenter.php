<?php

namespace App\User\Presentation;

use App\User\Infrastructure\LoginPresenterInterface;
use Twig\Environment;

class LoginPresenter implements LoginPresenterInterface
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function present(LoginViewModel $viewModel): string
    {
        return $this->twig->render('user/login.html.twig', [
            'viewModel' => $viewModel,
        ]);
    }
}