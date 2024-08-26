<?php

namespace App\Article\Application\UseCase;

use App\Article\Domain\Entity\Article;
use App\Article\Domain\Repositories\ArticleRepositoryInterface;

class GetArticleUseCase
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function execute(int $id): ?Article
    {
        return $this->articleRepository->findById($id);
    }
}