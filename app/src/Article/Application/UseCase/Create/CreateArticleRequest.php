<?php

namespace App\Article\Application\UseCase\Create;

class CreateArticleRequest
{
    public string $title;
    public string $description;

    public function __construct(string $title, string $description)
    {
        $this->title = $title;
        $this->description = $description;
    }
}