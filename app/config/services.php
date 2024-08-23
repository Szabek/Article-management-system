<?php

use App\Article\Infrastructure\Controller\ArticleController;
use App\User\Infrastructure\Controller\LoginController;
use App\User\Infrastructure\LoginPresenterInterface;
use App\User\Presentation\LoginPresenter;
use Szabek\Framework\Container;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return function (Container $container) {
    // Rejestracja usług Twig
    $container->set(Environment::class, function () {
        $loader = new FilesystemLoader(BASE_PATH . '/templates');
        return new Environment($loader);
    });

    // Rejestracja LoginPresenter
    $container->set(LoginPresenterInterface::class, function ($c) {
        return new LoginPresenter($c->get(Environment::class));
    });

    // Rejestracja LoginController
    $container->set(LoginController::class, function ($c) {
        return new LoginController($c->get(LoginPresenterInterface::class));
    });

    // Rejestracja ArticleController
    $container->set(ArticleController::class, function () {
        return new ArticleController();
    });
};