<?php

namespace Szabek\Framework\Http;

readonly class Request
{
    public function __construct(
        public array $getParams,
        public array $postParams,
        public array $cookies,
        public array $files,
        public array $server,
        public ?array $body = null,
    )
    {

    }

    public static function createFromGlobals(): static
    {
        $body = null;
        if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
            $input = file_get_contents('php://input');
            $body = json_decode($input, true);
        } else {
            $body = $_POST;
        }

        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER, $body);
    }

    public function getPathInfo(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }
}