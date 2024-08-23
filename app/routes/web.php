<?php

use App\Article\Infrastructure\Controller\ArticleController;
use App\Article\Infrastructure\Controller\HomeController;

return [
  ['GET', '/', [HomeController::class, 'index']],
  ['GET', '/articles/{id:\d+}', [ArticleController::class, 'show']],
];