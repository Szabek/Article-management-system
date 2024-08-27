<?php

use App\Article\Application\UseCase\CreateArticleUseCase;
use App\Article\Application\UseCase\DeleteArticleUseCase;
use App\Article\Application\UseCase\UpdateArticleUseCase;
use App\Article\Domain\Repositories\ArticleRepository;
use App\Article\Domain\Repositories\ArticleRepositoryInterface;
use App\Article\Infrastructure\Controller\ArticleController;
use App\Article\Infrastructure\Presenter\ArticlePresenter;
use App\Article\Infrastructure\Presenter\JsonArticleListPresenter;
use App\Article\Infrastructure\Presenter\JsonArticlePresenter;
use App\User\Application\Services\PasswordService;
use App\User\Application\UseCase\LoginPresenterInterface;
use App\User\Application\UseCase\LoginUserUseCase;
use App\User\Application\UseCase\LoginUserUseCaseInterface;
use App\User\Domain\Repository\UserRepository;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Infrastructure\Controller\LoginController;
use App\User\Infrastructure\Presenter\LoginPresenter;
use Config\Config;
use Szabek\Framework\Container;
use Szabek\Framework\Http\Middleware\AuthMiddleware;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return function (Container $container) {
    $container->set(Config::class, function () {
        return new Config();
    });

    $container->set(Environment::class, function () {
        $loader = new FilesystemLoader(BASE_PATH . '/templates');
        return new Environment($loader);
    });

    $container->set(PDO::class, function ($c) {
        $config = $c->get(Config::class);
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $config->get('db_host'),
            $config->get('db_port'),
            $config->get('db_name')
        );

        return new PDO($dsn, $config->get('db_user'), $config->get('db_password'));
    });

    $container->set(PasswordService::class, function () {
        return new PasswordService();
    });

    $container->set(UserRepositoryInterface::class, function ($c) {
        return new UserRepository(
            $c->get(PDO::class),
            $c->get(PasswordService::class)
        );
    });

    $container->set(LoginUserUseCaseInterface::class, function ($c) {
        return new LoginUserUseCase(
            $c->get(UserRepositoryInterface::class),
            $c->get(PasswordService::class)
        );
    });

    $container->set(LoginPresenterInterface::class, function ($c) {
        return new LoginPresenter($c->get(Environment::class));
    });

    $container->set(LoginController::class, function ($c) {
        return new LoginController(
            $c->get(LoginUserUseCaseInterface::class),
            $c->get(LoginPresenterInterface::class)
        );
    });

    $container->set(ArticlePresenter::class, function ($c) {
        return new ArticlePresenter($c->get(Environment::class));
    });

    $container->set(JsonArticleListPresenter::class, function ($c) {
        return new JsonArticleListPresenter();
    });

    $container->set(JsonArticlePresenter::class, function ($c) {
        return new JsonArticlePresenter();
    });

    $container->set(CreateArticleUseCase::class, function ($c) {
        return new CreateArticleUseCase($c->get(ArticleRepositoryInterface::class));
    });

    $container->set(UpdateArticleUseCase::class, function ($c) {
        return new UpdateArticleUseCase($c->get(ArticleRepositoryInterface::class));
    });

    $container->set(ArticleRepositoryInterface::class, function ($c) {
        return new ArticleRepository($c->get(PDO::class));
    });

    $container->set(DeleteArticleUseCase::class, function ($c) {
        return new DeleteArticleUseCase($c->get(ArticleRepositoryInterface::class));
    });

    $container->set(ArticleController::class, function ($c) {
        return new ArticleController(
            $c->get(CreateArticleUseCase::class),
            $c->get(UpdateArticleUseCase::class),
            $c->get(ArticlePresenter::class),
            $c->get(JsonArticlePresenter::class),
            $c->get(JsonArticleListPresenter::class),
            $c->get(ArticleRepositoryInterface::class),
            $c->get(DeleteArticleUseCase::class),
        );
    });

    $container->set(AuthMiddleware::class, function () {
        return new AuthMiddleware();
    });
};