<?php

namespace App\Article\Application\UseCase;

class ArticleListResponse
{
    public bool $success;
    public string $message;
    public array $data;

    public function __construct(bool $success, string $message = '', array $data = [])
    {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
    }
}