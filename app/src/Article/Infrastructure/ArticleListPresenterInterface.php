<?php

namespace App\Article\Infrastructure;

use App\Article\Presentation\ArticleViewModel;

interface ArticleListPresenterInterface
{
    /**
     * @param ArticleViewModel[] $articles
     * @return string
     */
    public function present(array $articles): string;
}