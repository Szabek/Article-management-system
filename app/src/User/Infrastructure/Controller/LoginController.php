<?php

namespace App\User\Infrastructure\Controller;

use App\User\Infrastructure\LoginPresenterInterface;
use App\User\Presentation\LoginViewModel;
use Szabek\Framework\Http\Response;

class LoginController
{
    private LoginPresenterInterface $presenter;

    public function __construct(LoginPresenterInterface $presenter)
    {
        $this->presenter = $presenter;
    }

    public function index(): Response
    {
        $viewModel = new LoginViewModel();

        $content = $this->presenter->present($viewModel);

        return new Response($content);
    }

}