<?php

namespace tests\Framework;

use PHPUnit\Framework\TestCase;
use Szabek\Framework\Container;
use Szabek\Framework\Http\Kernel;
use Szabek\Framework\Http\Middleware\Middleware;
use Szabek\Framework\Http\Request;
use Szabek\Framework\Http\Response;

class KernelTest extends TestCase
{
    protected function setUp(): void
    {
        if (!defined('BASE_PATH')) {
            define('BASE_PATH', __DIR__ . '/../../');
        }
    }
    public function testHandleNotFoundRoute()
    {
        $container = $this->createMock(Container::class);
        $kernel = new Kernel($container, []);

        $request = new Request([], [], [], [], ['REQUEST_URI' => '/non-existent', 'REQUEST_METHOD' => 'GET']);
        $response = $kernel->handle($request);

        $this->assertEquals(404, $response->getStatus());
        $this->assertEquals('404 Not Found', $response->getContent());
    }

    public function testHandleMethodNotAllowedRoute()
    {
        $container = $this->createMock(Container::class);
        $kernel = new Kernel($container, []);

        $request = new Request([], [], [], [], ['REQUEST_URI' => '/articles', 'REQUEST_METHOD' => 'POST']);
        $response = $kernel->handle($request);

        $this->assertEquals(405, $response->getStatus());
        $this->assertEquals('405 Method Not Allowed', $response->getContent());
    }
}