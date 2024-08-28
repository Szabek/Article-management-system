<?php

namespace App\Article\Application\UseCase\Delete;

use App\Article\Application\UseCase\ArticleResponse;
use App\Article\Domain\Repository\ArticleRepositoryInterface;
use Exception;

class DeleteArticleUseCase
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function execute(int $id): ArticleResponse
    {
        try {
            $this->articleRepository->delete($id);
            return new ArticleResponse(true, 'Article deleted successfully');
        } catch (Exception $e) {
            return new ArticleResponse(false, 'Failed to delete article: ' . $e->getMessage());
        }
    }
}