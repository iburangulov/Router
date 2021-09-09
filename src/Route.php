<?php

namespace Bonefabric\Router;

use Bonefabric\Router\Interfaces\RouteInterface;

final class Route implements RouteInterface
{

    /**
     * @var array
     */
    private $methods;

    /**
     * @var string
     */
    private $pattern;

    /**
     * @var callable
     */
    private $callback;

    /**
     * @param array $methods
     * @param string $pattern
     */
    public function __construct(array $methods, string $pattern, callable $callback)
    {
        $this->methods = $methods;
        $this->pattern = $pattern;
        $this->callback = $callback;
    }

    /**
     * @param string $method
     * @param string $pattern
     * @return bool
     */
    public function check(string $method, string $pattern): bool
    {
        return $pattern === $this->pattern && in_array($method, $this->methods, true);
    }

    /**
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }

}