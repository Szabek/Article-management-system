<?php

namespace App\Article\Infrastructure;

use App\Article\Application\UseCase\UseCaseResponse;

interface ArticlePresenterInterface
{
    public function present(UseCaseResponse $response): string;
}