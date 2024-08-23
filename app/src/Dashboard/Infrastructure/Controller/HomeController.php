<?php

namespace App\Dashboard\Infrastructure\Controller;

use Szabek\Framework\Http\Response;

class HomeController
{
    public function index(): Response
    {
        $content = '<h1>Hello world</h1>';

        return new Response($content);
    }
}