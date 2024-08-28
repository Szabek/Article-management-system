<?php

namespace App\Article\Application\UseCase;

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

    public function execute(CreateArticleRequest $request): UseCaseResponse
    {
        try {
            $article = new Article((int)null, $request->title, $request->description);
            $this->articleRepository->save($article);

            return new UseCaseResponse(true, 'Article created successfully', $article);
        } catch (Exception $e) {
            return new UseCaseResponse(false, $e->getMessage());
        }
    }
}