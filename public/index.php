<?php declare(strict_types=1);


use Szabek\Framework\Http\Request;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$request = Request::createFromGlobals();

echo 'Hello World!';