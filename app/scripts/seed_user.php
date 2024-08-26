<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../scripts/database.php';

$pdo = getPdoConnection();

$plainPassword = 'test';
$hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);

$stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = :username');
$stmt->execute(['username' => 'admin']);
$exists = $stmt->fetchColumn();

if (!$exists) {
    $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
    $stmt->execute([
        'username' => 'admin',
        'password' => $hashedPassword,
    ]);
    echo "Admin user created successfully.\n";
} else {
    echo "Admin user already exists.\n";
}