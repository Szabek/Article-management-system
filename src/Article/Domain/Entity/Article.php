<?php

namespace App\Article\Domain\Entity;

class Article
{
    private int $id;
    private string $title;
    private string $description;

    public function __construct(string $title, string $description, int $id = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}