<?php

namespace Framework\Router;

use Framework\Exception\RouterException;

class Router
{
    private $url;
    private $routes = array();

    public function __construct($url)
    {
        $this->url = $url;
    }

    private function add($path, $callable, $method)
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;

        return $route;
    }

    public function get($path, $callable)
    {
        return $this->add($path, $callable, 'GET');
    }

    public function post($path, $callable)
    {
        return $this->add($path, $callable, 'POST');
    }

    public function run()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new RouterException("REQUEST_METHOD doesn't exist");
        }

        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                return $route->call();
            }
        }

        throw new RouterException("No matching routes");
    }
}
