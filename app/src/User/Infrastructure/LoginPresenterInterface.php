<?php

namespace App\User\Infrastructure;

use App\User\Presentation\LoginViewModel;

interface LoginPresenterInterface
{
    public function present(LoginViewModel $viewModel): string;
}