<?php

use App\Article\Infrastructure\Controller\ArticleController;
use App\User\Infrastructure\Controller\LoginController;

return [
    ['GET', '/', [LoginController::class, 'index']],
    ['GET', '/login', [LoginController::class, 'index']],
    ['POST', '/login', [LoginController::class, 'login']],
    ['POST', '/api/logout', [LoginController::class, 'logout']],
    ['GET', '/articles', [ArticleController::class, 'listHtml']],
    ['GET', '/api/articles', [ArticleController::class, 'listJson']],
    ['POST', '/api/articles', [ArticleController::class, 'create']],
    ['PUT', '/api/articles/{id:\d+}', [ArticleController::class, 'update']],
    ['DELETE', '/api/articles/{id:\d+}', [ArticleController::class, 'delete']],
];