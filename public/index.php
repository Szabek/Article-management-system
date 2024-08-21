<?php declare(strict_types=1);


use Szabek\Framework\Http\Kernel;
use Szabek\Framework\Http\Request;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$request = Request::createFromGlobals();


$kernel = new Kernel();

$response = $kernel->handle($request);

$response->send();