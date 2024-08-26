<?php

namespace App\Article\Infrastructure\Presenter;

use App\Article\Infrastructure\ArticleListPresenterInterface;
use Twig\Environment;

class ArticleListPresenter implements ArticleListPresenterInterface
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param ArticleViewModel[] $articles
     * @return string
     */
    public function present(array $articles): string
    {
        return $this->twig->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}