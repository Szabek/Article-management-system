<?php

use App\Article\Application\UseCase\ArticleListResponse;
use App\Article\Application\UseCase\CreateArticle\CreateArticleUseCase;
use App\Article\Application\UseCase\DeleteArticle\DeleteArticleUseCase;
use App\Article\Application\UseCase\UpdateArticle\UpdateArticleUseCase;
use App\Article\Domain\Repository\ArticleRepositoryInterface;
use App\Article\Infrastructure\Controller\ArticleController;
use App\Article\Infrastructure\Presenter\HtmlArticlePresenter;
use App\Article\Infrastructure\Presenter\JsonArticleListPresenter;
use App\Article\Infrastructure\Presenter\JsonArticlePresenter;
use PHPUnit\Framework\TestCase;
use Szabek\Framework\Http\Request;
use Szabek\Framework\Http\Response;

class ArticleControllerTest extends TestCase
{
    private $controller;
    private $createArticleUseCase;
    private $updateArticleUseCase;
    private $htmlArticlePresenter;
    private $jsonArticlePresenter;
    private $jsonArticleListPresenter;
    private $articleRepository;
    private $deleteArticleUseCase;

    protected function setUp(): void
    {
        $this->createArticleUseCase = $this->createMock(CreateArticleUseCase::class);
        $this->updateArticleUseCase = $this->createMock(UpdateArticleUseCase::class);
        $this->htmlArticlePresenter = $this->createMock(HtmlArticlePresenter::class);
        $this->jsonArticlePresenter = $this->createMock(JsonArticlePresenter::class);
        $this->jsonArticleListPresenter = $this->createMock(JsonArticleListPresenter::class);
        $this->articleRepository = $this->createMock(ArticleRepositoryInterface::class);
        $this->deleteArticleUseCase = $this->createMock(DeleteArticleUseCase::class);

        $this->controller = new ArticleController(
            $this->createArticleUseCase,
            $this->updateArticleUseCase,
            $this->htmlArticlePresenter,
            $this->jsonArticlePresenter,
            $this->jsonArticleListPresenter,
            $this->articleRepository,
            $this->deleteArticleUseCase
        );
    }

    public function testListHtml()
    {
        $response = new ArticleListResponse(true, '');
        $this->htmlArticlePresenter
            ->expects($this->once())
            ->method('present')
            ->with($this->equalTo($response))
            ->willReturn('HTML content');

        $request = $this->createMock(Request::class);
        $result = $this->controller->listHtml($request);

        $this->assertInstanceOf(Response::class, $result);
        $this->assertEquals(200, $result->getStatus());
        $this->assertEquals('HTML content', $result->getContent());
    }

    public function testListJson()
    {
        $articles = [];
        $this->articleRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($articles);

        $response = new ArticleListResponse(true, 'Articles retrieved successfully', $articles);
        $this->jsonArticleListPresenter
            ->expects($this->once())
            ->method('present')
            ->with($this->equalTo($response))
            ->willReturn(json_encode($articles));

        $result = $this->controller->listJson();

        $this->assertInstanceOf(Response::class, $result);
        $this->assertEquals(200, $result->getStatus());
        $this->assertEquals(json_encode($articles), $result->getContent());
    }
}