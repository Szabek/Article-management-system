<?php

namespace App\Article\Infrastructure\Presenter;

use App\Article\Application\UseCase\UseCaseResponse;
use App\Article\Infrastructure\ArticlePresenterInterface;

class JsonArticleListPresenter implements ArticlePresenterInterface
{
    public function present(UseCaseResponse $response): string
    {
        $formattedData = array_map(function ($article) {
            $viewModel = new ArticleViewModel(
                $article->getId(),
                $article->getTitle(),
                $article->getDescription()
            );

            return [
                'id' => $viewModel->id,
                'title' => $viewModel->title,
                'description' => $viewModel->description,
            ];
        }, $response->data);

        return json_encode([
            'success' => $response->success,
            'message' => $response->message,
            'data' => $formattedData
        ]);
    }
}