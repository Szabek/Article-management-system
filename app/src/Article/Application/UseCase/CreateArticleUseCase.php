<?php

namespace App\Article\Application\UseCase;

use App\Article\Domain\Entity\Article;
use App\Article\Domain\Repositories\ArticleRepositoryInterface;

class CreateArticleUseCase
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function execute(string $title, string $description): Article
    {
        $article = new Article($title, $description);
        $this->articleRepository->save($article);
        return $article;
    }
}