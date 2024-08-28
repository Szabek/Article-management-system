<?php

namespace Szabek\Framework\Http;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Szabek\Framework\Container;
use Szabek\Framework\Http\Middleware\Middleware;
use function FastRoute\simpleDispatcher;

class Kernel
{
    private Container $container;
    private array $middlewares = [];

    public function __construct(Container $container, array $middlewares = [])
    {
        $this->container = $container;
        $this->middlewares = $middlewares;
    }

    public function handle(Request $request): Response
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {
            $webRoutes = include BASE_PATH . '/routes/web.php';
            $apiRoutes = include BASE_PATH . '/routes/api.php';

            foreach ($webRoutes as $route) {
                $routeCollector->addRoute(...$route);
            }

            foreach ($apiRoutes as $route) {
                $routeCollector->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPathInfo()
        );

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                return new Response('404 Not Found', 404);
            case Dispatcher::METHOD_NOT_ALLOWED:
                return new Response('405 Method Not Allowed', 405);
            case Dispatcher::FOUND:
                [$controllerName, $method] = $routeInfo[1];
                $vars = $routeInfo[2];

                $controller = $this->container->get($controllerName);

                $params = array_merge([$request], array_values($vars));

                $response = $this->handleMiddleware($request, function ($request) use ($controller, $method, $params) {
                    return call_user_func_array([$controller, $method], $params);
                });

                return $response;
            default:
                return new Response('500 Internal Server Error', 500);
        }
    }

    private function handleMiddleware(Request $request, callable $next): Response
    {
        if (empty($this->middlewares)) {
            return $next($request);
        }

        $middleware = array_shift($this->middlewares);

        /** @var Middleware $middlewareInstance */
        $middlewareInstance = $this->container->get($middleware);

        return $middlewareInstance->process($request, function ($request) use ($next) {
            return $this->handleMiddleware($request, $next);
        });
    }
}