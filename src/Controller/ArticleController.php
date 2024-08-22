<?php

namespace App\Controller;

use Szabek\Framework\Http\Response;

class ArticleController
{
    public function show(int $id): Response
    {
        $content = "Article $id";

        return new Response($content);
    }
}