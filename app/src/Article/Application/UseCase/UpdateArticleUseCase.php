<?php

namespace App\Article\Application\UseCase;

use App\Article\Domain\Repositories\ArticleRepositoryInterface;
use App\Article\Domain\UseCase\Article;
use Exception;

class UpdateArticleUseCase
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function execute(UpdateArticleRequest $request): UseCaseResponse
    {
        try {
            $article = $this->articleRepository->findById($request->id);

            if (!$article) {
                return new UseCaseResponse(false, 'Article not found');
            }

            $article->setTitle($request->title);
            $article->setDescription($request->description);

            $this->articleRepository->update($article);

            return new UseCaseResponse(true, 'Article updated successfully', $article);
        } catch (Exception $e) {
            return new UseCaseResponse(false, 'Failed to update article: ' . $e->getMessage());
        }
    }
}