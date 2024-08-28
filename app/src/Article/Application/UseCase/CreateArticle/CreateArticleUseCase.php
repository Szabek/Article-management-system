<?php

namespace App\Article\Application\UseCase\CreateArticle;

use App\Article\Application\UseCase\ArticleResponse;
use App\Article\Domain\Entity\Article;
use App\Article\Domain\Repository\ArticleRepositoryInterface;
use Exception;

class CreateArticleUseCase
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function execute(CreateArticleRequest $request): ArticleResponse
    {
        try {
            $article = new Article(null, $request->title, $request->description);
            $this->articleRepository->save($article);

            return new ArticleResponse(true, 'Article created successfully', $article);
        } catch (Exception $e) {
            return new ArticleResponse(false, $e->getMessage());
        }
    }
}