<?php

namespace App\Article\Domain\UseCase;

use App\Article\Domain\Repositories\ArticleRepositoryInterface;
use Exception;

class DeleteArticleUseCase
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(int $id): void
    {
        $article = $this->articleRepository->findById($id);

        if ($article === null) {
            throw new Exception("Article with ID {$id} not found.");
        }

        $this->articleRepository->delete($id);
    }
}