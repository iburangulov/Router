<?php

namespace Bonefabric\Router\Interfaces;

interface RouteInterface
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_PATCH = 'PATCH';
    const METHOD_DELETE = 'DELETE';

    const METHODS = [
        self::METHOD_GET,
        self::METHOD_POST,
        self::METHOD_PUT,
        self::METHOD_PATCH,
        self::METHOD_DELETE,
    ];

    /**
     * @param string $method
     * @param string $pattern
     * @return bool
     */
    public function check(string $method, string $pattern): bool;

    /**
     * @return callable
     */
    public function getCallback(): callable;

}