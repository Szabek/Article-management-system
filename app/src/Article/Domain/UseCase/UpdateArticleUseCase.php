<?php

namespace App\Article\Domain\UseCase;

use App\Article\Domain\Repositories\ArticleRepositoryInterface;
use Exception;

class UpdateArticleUseCase
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(int $id, string $title, string $description): void
    {
        $article = $this->articleRepository->findById($id);

        if ($article === null) {
            throw new Exception("Article with ID {$id} not found.");
        }

        $updatedArticle = new Article($title, $description, $id);

        $this->articleRepository->update($updatedArticle);
    }
}