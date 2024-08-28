<?php

namespace App\Article\Infrastructure\Presenter;

use App\Article\Application\UseCase\UseCaseResponse;
use App\Article\Domain\Entity\Article;

class JsonArticlePresenter
{
    public function present(UseCaseResponse $response): string
    {
        if ($response->data instanceof Article) {
            $viewModel = new ArticleViewModel(
                $response->data->getId(),
                $response->data->getTitle(),
                $response->data->getDescription()
            );

            $formattedData = [
                'id' => $viewModel->id,
                'title' => $viewModel->title,
                'description' => $viewModel->description,
            ];
        } else {
            $formattedData = null;
        }

        return json_encode([
            'success' => $response->success,
            'message' => $response->message,
            'data' => $formattedData
        ]);
    }
}