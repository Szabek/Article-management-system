<?php

namespace App\Article\Infrastructure\Presenter;

use App\Article\Application\UseCase\ArticleListResponse;
use App\Article\Infrastructure\ArticlePresenterInterface;
use Twig\Environment;

class ArticlePresenter implements ArticlePresenterInterface
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function present(ArticleListResponse $response): string
    {
        if ($response->success) {
            return $this->twig->render('articles/index.html.twig', [
                'articles' => $response->data,
            ]);
        }

        return $this->twig->render('articles/error.html.twig', [
            'message' => $response->message,
        ]);
    }
}