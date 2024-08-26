<?php

namespace App\Article\Infrastructure;

use App\Article\Infrastructure\Presenter\ArticleViewModel;

interface ArticleListPresenterInterface
{
    /**
     * @param ArticleViewModel[] $articles
     * @return string
     */
    public function present(array $articles): string;
}