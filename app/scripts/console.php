<?php

$command = $argv[1] ?? null;

switch ($command) {
    case 'migrate':
        require 'migrate.php';
        break;
    case 'seed':
        require 'seed_user.php';
        break;
    default:
        echo "Available commands: migrate, seed\n";
        break;
}