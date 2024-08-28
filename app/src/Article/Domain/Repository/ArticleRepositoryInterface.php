<?php

namespace App\Article\Domain\Repository;

use App\Article\Domain\Entity\Article;

interface ArticleRepositoryInterface
{
    public function findById(int $id): ?Article;
    public function findAll(): array;
    public function save(Article $article): void;
    public function update(Article $article): void;
    public function delete(int $id): void;
}