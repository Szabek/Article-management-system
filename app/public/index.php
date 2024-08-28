<?php declare(strict_types=1);

use Szabek\Framework\Container;
use Szabek\Framework\Http\Kernel;
use Szabek\Framework\Http\Middleware\AuthMiddleware;
use Szabek\Framework\Http\Request;

define('BASE_PATH', dirname(__DIR__));

require_once dirname(__DIR__) . '/vendor/autoload.php';

session_start();

// Container initialization
$container = new Container();

// Service registration
$registerServices = require BASE_PATH . '/config/services.php';
$registerServices($container);

$kernel = new Kernel($container, [
    AuthMiddleware::class,
]);

// Launching the application
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();