<?php

namespace Szabek\Framework\Http;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Szabek\Framework\Container;
use function FastRoute\simpleDispatcher;

class Kernel
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function handle(Request $request): Response
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {
            $routes = include BASE_PATH . '/routes/web.php';

            foreach ($routes as $route) {
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
                $response = call_user_func_array([$controller, $method], $vars);

                return $response;
            default:
                return new Response('500 Internal Server Error', 500);
        }
    }
}