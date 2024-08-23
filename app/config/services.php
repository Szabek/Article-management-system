<?php

use App\Article\Infrastructure\ArticleListPresenterInterface;
use App\Article\Infrastructure\Controller\ArticleController;
use App\Article\Presentation\ArticleListPresenter;
use App\User\Infrastructure\Controller\LoginController;
use App\User\Infrastructure\LoginPresenterInterface;
use App\User\Presentation\LoginPresenter;
use Szabek\Framework\Container;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return function (Container $container) {
    $container->set(Environment::class, function () {
        $loader = new FilesystemLoader(BASE_PATH . '/templates');
        return new Environment($loader);
    });

    $container->set(LoginPresenterInterface::class, function ($c) {
        return new LoginPresenter($c->get(Environment::class));
    });

    $container->set(LoginController::class, function ($c) {
        return new LoginController($c->get(LoginPresenterInterface::class));
    });

    $container->set(ArticleListPresenterInterface::class, function ($c) {
        return new ArticleListPresenter($c->get(Environment::class));
    });

    $container->set(ArticleController::class, function ($c) {
        return new ArticleController($c->get(ArticleListPresenterInterface::class));
    });
};