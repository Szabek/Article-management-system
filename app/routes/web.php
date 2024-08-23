<?php

use App\Article\Infrastructure\Controller\ArticleController;
use App\User\Infrastructure\Controller\LoginController;

return [
    ['GET', '/', [LoginController::class, 'index']],
    ['GET', '/articles', [ArticleController::class, 'index']],
    ['GET', '/articles/{id:\d+}', [ArticleController::class, 'show']],
];