<?php declare(strict_types=1);

use Szabek\Framework\Container;
use Szabek\Framework\Http\Kernel;
use Szabek\Framework\Http\Request;

define('BASE_PATH', dirname(__DIR__));

require_once dirname(__DIR__) . '/vendor/autoload.php';

// Container initialization
$container = new Container();

// Service registration
$registerServices = require BASE_PATH . '/config/services.php';
$registerServices($container);

// Launching the application
$request = Request::createFromGlobals();
$kernel = new Kernel($container);

$response = $kernel->handle($request);
$response->send();