<?php

namespace App\Article\Infrastructure\Presenter;

use App\Article\Application\UseCase\ArticleListResponse;
use App\Article\Domain\Entity\Article;
use App\Article\Infrastructure\ArticlePresenterInterface;

class JsonArticleListPresenter implements ArticlePresenterInterface
{
    public function present(ArticleListResponse $response): string
    {
        $mappedData = array_map(function (Article $article) {
            return [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'description' => $article->getDescription(),
            ];
        }, $response->data);

        return json_encode([
            'success' => $response->success,
            'message' => $response->message,
            'data' => $mappedData
        ]);
    }
}