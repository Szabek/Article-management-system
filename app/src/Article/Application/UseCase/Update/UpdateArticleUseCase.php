<?php

namespace App\Article\Application\UseCase\Update;

use App\Article\Application\UseCase\ArticleResponse;
use App\Article\Domain\Repository\ArticleRepositoryInterface;
use Exception;

class UpdateArticleUseCase
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function execute(UpdateArticleRequest $request): ArticleResponse
    {
        try {
            $article = $this->articleRepository->findById($request->id);

            if (!$article) {
                return new ArticleResponse(false, 'Article not found');
            }

            $article->setTitle($request->title);
            $article->setDescription($request->description);

            $this->articleRepository->update($article);

            return new ArticleResponse(true, 'Article updated successfully', $article);
        } catch (Exception $e) {
            return new ArticleResponse(false, 'Failed to update article: ' . $e->getMessage());
        }
    }
}