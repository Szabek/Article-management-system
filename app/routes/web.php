<?php

use App\Article\Infrastructure\Controller\ArticleController;
use App\User\Infrastructure\Controller\LoginController;

return [
    ['GET', '/', [LoginController::class, 'index']],
    ['GET', '/login', [LoginController::class, 'index']],
    ['POST', '/login', [LoginController::class, 'login']],
    ['GET', '/articles', [ArticleController::class, 'listHtml']],
];