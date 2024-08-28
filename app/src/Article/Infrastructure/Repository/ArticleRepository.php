<?php

namespace App\Article\Infrastructure\Repository;

use App\Article\Domain\Entity\Article;
use App\Article\Domain\Repository\ArticleRepositoryInterface;
use PDO;

class ArticleRepository implements ArticleRepositoryInterface
{

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function findById(int $id): ?Article
    {
        $stmt = $this->pdo->prepare('SELECT * FROM articles WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Article($row['id'], $row['title'], $row['description']);
        }

        return null;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM articles');
        $articles = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $articles[] = new Article($row['id'], $row['title'], $row['description'],);
        }

        return $articles;
    }

    public function save(Article $article): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO articles (title, description) VALUES (:title, :description)');
        $stmt->execute([
            'title' => $article->getTitle(),
            'description' => $article->getDescription(),
        ]);

        $article->setId((int) $this->pdo->lastInsertId());
    }

    public function update(Article $article): void
    {
        if ($article->getId() === null) {
            throw new \InvalidArgumentException('Article must have an ID to be updated.');
        }

        $stmt = $this->pdo->prepare('UPDATE articles SET title = :title, description = :description WHERE id = :id');
        $stmt->execute([
            'title' => $article->getTitle(),
            'description' => $article->getDescription(),
            'id' => $article->getId()
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM articles WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}