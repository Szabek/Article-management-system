<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../scripts/database.php';

$pdo = getPdoConnection();

$migrationsPath = __DIR__ . '/../database/migrations';
$migrationFiles = glob($migrationsPath . '/*.sql');

foreach ($migrationFiles as $file) {
    $sql = file_get_contents($file);
    $pdo->exec($sql);
    echo "Executed migration: " . basename($file) . "\n";
}