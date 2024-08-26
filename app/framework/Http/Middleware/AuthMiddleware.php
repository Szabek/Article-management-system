<?php

namespace Szabek\Framework\Http\Middleware;

use Szabek\Framework\Http\Request;
use Szabek\Framework\Http\Response;

class AuthMiddleware
{
    private array $publicPaths;
    private string $loginPath;

    public function __construct()
    {
        $this->publicPaths = explode(',', getenv('PUBLIC_PATHS') ?: '/login');
        $this->loginPath = getenv('LOGIN_PATH') ?: '/login';
    }
    public function process(Request $request, callable $next): Response
    {
        if (!isset($_SESSION['user']) && !in_array($request->getPathInfo(), $this->publicPaths)) {
            return new Response('Unauthorized', 302, ['Location' => $this->loginPath]);
        }

        return $next($request);
    }
}