<?php

use App\Article\Infrastructure\Controller\ArticleController;
use App\User\Infrastructure\Controller\LoginController;

return [
    ['POST', '/api/logout', [LoginController::class, 'logout']],
    ['GET', '/api/articles', [ArticleController::class, 'listJson']],
    ['POST', '/api/articles', [ArticleController::class, 'create']],
    ['PUT', '/api/articles/{id:\d+}', [ArticleController::class, 'update']],
    ['DELETE', '/api/articles/{id:\d+}', [ArticleController::class, 'delete']],
];