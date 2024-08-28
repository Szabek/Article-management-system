<?php

namespace App\Article\Infrastructure;

use App\Article\Application\UseCase\ArticleListResponse;

interface ArticlePresenterInterface
{
    public function present(ArticleListResponse $response): string;
}