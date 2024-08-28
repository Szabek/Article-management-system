<?php

namespace App\User\Domain\Repository;

use App\User\Application\Services\PasswordService;
use App\User\Domain\Entity\User;
use PDO;

class UserRepository implements UserRepositoryInterface
{
    private PDO $pdo;
    private PasswordService $passwordService;

    public function __construct(PDO $pdo, PasswordService $passwordService)
    {
        $this->pdo = $pdo;
        $this->passwordService = $passwordService;
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new User($data['username'], $data['password'], $data['id']);
    }

    public function findByUsername(string $username): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new User($data['username'], $data['password'], $data['id']);
    }

    public function save(User $user): void
    {
        if ($user->getId() === null) {
            $stmt = $this->pdo->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
            $stmt->execute([
                'username' => $user->getUsername(),
                'password' => $this->passwordService->hashPassword($user->getPassword())
            ]);
            $user->setId((int) $this->pdo->lastInsertId());
        } else {
            $stmt = $this->pdo->prepare('UPDATE users SET username = :username, password = :password WHERE id = :id');
            $stmt->execute([
                'username' => $user->getUsername(),
                'password' => $this->passwordService->hashPassword($user->getPassword()),
                'id' => $user->getId()
            ]);
        }
    }
}