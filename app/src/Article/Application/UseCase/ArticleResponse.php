<?php

namespace App\Article\Application\UseCase;

use App\Article\Domain\Entity\Article;

class ArticleResponse
{
    public bool $success;
    public string $message;
    public ?Article $article;

    public function __construct(bool $success, string $message = '', ?Article $article = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->article = $article;
    }
}