<?php

namespace App\Article\Infrastructure\Presenter;

use App\Article\Application\UseCase\ArticleResponse;

class JsonArticlePresenter
{
    public function present(ArticleResponse $response): string
    {
        $article = $response->article;

        $articleView = null;

        if (null !== $article) {
            $articleView = [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'description' => $article->getDescription(),
            ];
        }

        return json_encode([
            'success' => $response->success,
            'message' => $response->message,
            'data' => $articleView
        ]);
    }
}