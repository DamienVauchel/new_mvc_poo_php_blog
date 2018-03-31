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

    public function get($name, $callable)
    {
        $path = $this->findPath($name);

        return $this->add($path, $callable, 'GET');
    }

    public function post($name, $callable)
    {
        $path = $this->findPath($name);

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

    public function findPath($name)
    {
        $routes = yaml_parse_file('app/config/routes.yaml');
        $routes = $routes['routes'];

        $path = null;

        foreach ($routes as $route) {
            if ($route['name'] == $name) {
                $path = $route['path'];
            }
        }

        return $path;
    }
}
