<?php

namespace Config;
class Config
{
    private array $config;

    public function __construct()
    {
        $this->config = [
            'db_host' => getenv('MYSQL_HOST'),
            'db_port' => getenv('MYSQL_PORT'),
            'db_name' => getenv('MYSQL_DATABASE'),
            'db_user' => getenv('MYSQL_USER'),
            'db_password' => getenv('MYSQL_PASSWORD'),
            'redis_port' => getenv('REDIS_PORT'),
        ];
    }

    public function get(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }
}