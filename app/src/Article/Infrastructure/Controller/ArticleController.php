<?php

namespace App\Article\Infrastructure\Controller;

use App\Article\Infrastructure\ArticleListPresenterInterface;
use App\Article\Presentation\ArticleViewModel;
use Szabek\Framework\Http\Response;

class ArticleController
{
    private ArticleListPresenterInterface $presenter;

    public function __construct(ArticleListPresenterInterface $presenter)
    {
        $this->presenter = $presenter;
    }

    public function index(): Response
    {
        $articles = [
            new ArticleViewModel(1, 'Test', 'This is a Test'),
            new ArticleViewModel(2, 'Test 2', 'This is the Test 2'),
        ];

        $content = $this->presenter->present($articles);

        return new Response($content);
    }

    public function show(int $id): Response
    {
        $content = "Article $id";

        return new Response($content);
    }
}