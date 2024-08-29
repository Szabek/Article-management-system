<?php

namespace tests\Framework;

use PHPUnit\Framework\TestCase;
use Szabek\Framework\Http\Middleware\AuthMiddleware;
use Szabek\Framework\Http\Request;
use Szabek\Framework\Http\Response;

class AuthMiddlewareTest extends TestCase
{
    public function testRedirectsToLoginWhenNotAuthenticated()
    {
        $request = new Request([], [], [], [], ['REQUEST_URI' => '/protected-route']);
        $middleware = new AuthMiddleware();

        $response = $middleware->process($request, function () {
            return new Response('Next middleware called');
        });

        $this->assertEquals(302, $response->getStatus());
        $this->assertEquals('/login', $response->getHeaders()['Location']);
    }

    public function testAllowsAccessToPublicPathWhenNotAuthenticated()
    {
        $request = new Request([], [], [], [], ['REQUEST_URI' => '/login']);
        $middleware = new AuthMiddleware();

        $response = $middleware->process($request, function () {
            return new Response('Next middleware called');
        });

        $this->assertEquals('Next middleware called', $response->getContent());
    }

    public function testAllowsAccessWhenAuthenticated()
    {
        $_SESSION['user'] = 'user';
        $request = new Request([], [], [], [], ['REQUEST_URI' => '/protected-route']);
        $middleware = new AuthMiddleware();

        $response = $middleware->process($request, function () {
            return new Response('Next middleware called');
        });

        $this->assertEquals('Next middleware called', $response->getContent());
    }
}