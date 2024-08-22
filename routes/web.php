<?php

use App\Controller\ArticleController;
use App\Controller\HomeController;

return [
  ['GET', '/', [HomeController::class, 'index']],
  ['GET', '/articles/{id:\d+}', [ArticleController::class, 'show']],
];