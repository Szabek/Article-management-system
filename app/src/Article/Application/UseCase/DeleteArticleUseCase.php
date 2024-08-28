<?php

namespace App\Article\Application\UseCase;

use App\Article\Domain\Repositories\ArticleRepositoryInterface;
use Exception;

class DeleteArticleUseCase
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function execute(int $id): UseCaseResponse
    {
        try {
            $this->articleRepository->delete($id);
            return new UseCaseResponse(true, 'Article deleted successfully');
        } catch (Exception $e) {
            return new UseCaseResponse(false, 'Failed to delete article: ' . $e->getMessage());
        }
    }
}