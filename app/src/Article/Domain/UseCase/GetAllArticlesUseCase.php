<?php

namespace App\Article\Domain\UseCase;

use App\Article\Domain\Entity\Article;
use App\Article\Domain\Repositories\ArticleRepositoryInterface;

class GetAllArticlesUseCase
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @return Article[]
     */
    public function execute(): array
    {
        return $this->articleRepository->findAll();
    }
}