<?php

function getPdoConnection(): PDO
{
    $host = getenv('MYSQL_HOST');
    $port = getenv('MYSQL_PORT');
    $dbname = getenv('MYSQL_DATABASE');
    $user = getenv('MYSQL_USER');
    $password = getenv('MYSQL_PASSWORD');

    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $dbname);
    return new PDO($dsn, $user, $password);
}