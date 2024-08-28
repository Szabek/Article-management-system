<?php

namespace App\Article\Infrastructure\Controller;

use App\Article\Application\UseCase\ArticleListResponse;
use App\Article\Application\UseCase\Create\CreateArticleRequest;
use App\Article\Application\UseCase\Create\CreateArticleUseCase;
use App\Article\Application\UseCase\Delete\DeleteArticleUseCase;
use App\Article\Application\UseCase\Update\UpdateArticleRequest;
use App\Article\Application\UseCase\Update\UpdateArticleUseCase;
use App\Article\Domain\Repository\ArticleRepositoryInterface;
use App\Article\Infrastructure\Presenter\ArticlePresenter;
use App\Article\Infrastructure\Presenter\JsonArticleListPresenter;
use App\Article\Infrastructure\Presenter\JsonArticlePresenter;
use Szabek\Framework\Http\Request;
use Szabek\Framework\Http\Response;

class ArticleController
{
    private CreateArticleUseCase $createArticleUseCase;
    private UpdateArticleUseCase $updateArticleUseCase;
    private ArticlePresenter $htmlArticlePresenter;
    private JsonArticlePresenter $jsonArticlePresenter;
    private JsonArticleListPresenter $jsonArticleListPresenter;
    private ArticleRepositoryInterface $articleRepository;

    private DeleteArticleUseCase $deleteArticleUseCase;

    public function __construct(
        CreateArticleUseCase       $createArticleUseCase,
        UpdateArticleUseCase       $updateArticleUseCase,
        ArticlePresenter           $htmlArticlePresenter,
        JsonArticlePresenter       $jsonArticlePresenter,
        JsonArticleListPresenter   $jsonArticleListPresenter,
        ArticleRepositoryInterface $articleRepository,
        DeleteArticleUseCase       $deleteArticleUseCase
    )
    {
        $this->createArticleUseCase = $createArticleUseCase;
        $this->updateArticleUseCase = $updateArticleUseCase;
        $this->htmlArticlePresenter = $htmlArticlePresenter;
        $this->jsonArticlePresenter = $jsonArticlePresenter;
        $this->jsonArticleListPresenter = $jsonArticleListPresenter;
        $this->articleRepository = $articleRepository;
        $this->deleteArticleUseCase = $deleteArticleUseCase;
    }

    public function listHtml(Request $request): Response
    {
        $content = $this->htmlArticlePresenter->present(new ArticleListResponse(true, ''));
        return new Response($content, 200, ['Content-Type' => 'text/html']);
    }

    public function listJson(): Response
    {
        $articles = $this->articleRepository->findAll();

        $response = new ArticleListResponse(true, 'Articles retrieved successfully', $articles);

        $content = $this->jsonArticleListPresenter->present($response);

        return new Response($content, 200, ['Content-Type' => 'application/json']);
    }

    public function create(Request $request): Response
    {
        $createRequest = new CreateArticleRequest(
            $request->body['title'] ?? '',
            $request->body['description'] ?? ''
        );

        $response = $this->createArticleUseCase->execute($createRequest);

        $content = $this->jsonArticlePresenter->present($response);

        return new Response($content, $response->success ? 201 : 400, [
            'Content-Type' => 'application/json'
        ]);
    }

    public function update(Request $request, int $id): Response
    {

        $updateRequest = new UpdateArticleRequest(
            $id,
            $request->body['title'] ?? '',
            $request->body['description'] ?? ''
        );

        $response = $this->updateArticleUseCase->execute($updateRequest);

        $content = $this->jsonArticlePresenter->present($response);

        return new Response($content, $response->success ? 200 : 400, [
            'Content-Type' => 'application/json'
        ]);
    }

    public function delete(Request $request, int $id): Response
    {
        $response = $this->deleteArticleUseCase->execute($id);

        $content = $this->jsonArticlePresenter->present($response);

        return new Response($content, $response->success ? 200 : 400, [
            'Content-Type' => 'application/json'
        ]);
    }
}