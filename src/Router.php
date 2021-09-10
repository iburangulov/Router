<?php

namespace Bonefabric\Router;

use Bonefabric\Router\Exceptions\RouterException;
use Bonefabric\Router\Interfaces\RouteInterface;

final class Router
{

    /**
     * @var array
     */
    private $routes;

    /**
     * @param string $method
     * @param string $pattern
     * @throws RouterException
     */
    public function handle(string $method, string $pattern): void
    {
        $method = strtoupper($method);
        if (!in_array($method, RouteInterface::METHODS)) {
            throw new RouterException('Unsupported method');
        }
        /** @var RouteInterface $route */
        foreach ($this->routes as $route) {
            if ($route->check($method, $pattern)) {
                call_user_func($route->getCallback());
            }
        }
    }

    /**
     * Регистрация GET - маршрута
     */
    public function get(string $pattern, callable $callback): void
    {
        $this->routes[] = new Route([RouteInterface::METHOD_GET], $pattern, $callback);
    }

    /**
     * Регистрация POST - маршрута
     */
    public function post(string $pattern, callable $callback): void
    {
        $this->routes[] = new Route([RouteInterface::METHOD_POST], $pattern, $callback);
    }

    /**
     * Регистрация PUT - маршрута
     */
    public function put(string $pattern, callable $callback): void
    {
        $this->routes[] = new Route([RouteInterface::METHOD_PUT], $pattern, $callback);
    }

    /**
     * Регистрация PATCH - маршрута
     */
    public function patch(string $pattern, callable $callback): void
    {
        $this->routes[] = new Route([RouteInterface::METHOD_PATCH], $pattern, $callback);
    }

    /**
     * Регистрация DELETE - маршрута
     */
    public function delete(string $pattern, callable $callback): void
    {
        $this->routes[] = new Route([RouteInterface::METHOD_DELETE], $pattern, $callback);
    }

    /**
     * Регистрация маршрута для нескольких методов
     * @throws RouterException
     */
    public function match(array $methods, string $pattern, callable $callback): void
    {
        $this->routes[] = new Route($this->validateMethods($methods), $pattern, $callback);
    }

    /**
     * Регистрация маршрута для всех методов
     */
    public function any(string $pattern, callable $callback): void
    {
        $this->routes[] = new Route(RouteInterface::METHODS, $pattern, $callback);
    }

    /**
     * Регистрация маршрута для случая, если
     * нет подходящих маршрутов
     */
    public function fallback(callable $callback): void
    {
        $this->routes[] = new Route(RouteInterface::METHODS, '.*', $callback);
    }

    /**
     * @param array $methods
     * @return array
     * @throws RouterException
     */
    private function validateMethods(array $methods): array
    {
        foreach ($methods as &$method) {
            $method = strtoupper($method);
            if (!in_array($method, RouteInterface::METHODS, true)) {
                throw new RouterException('Unsupported method');
            }
        }
        return array_unique($methods);
    }

}