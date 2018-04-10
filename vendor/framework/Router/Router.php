<?php

namespace Framework\Router;

use Framework\Exception\RouterException;

/**
 * Class Router
 * @package Framework\Router
 */
class Router
{
    /**
     * @var
     */
    private $url;
    /**
     * @var array
     */
    private $routes = array();

    /**
     * Router constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @param $path
     * @param $callable
     * @param $method
     * @return Route
     */
    private function add($path, $callable, $method)
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;

        return $route;
    }

    /**
     * @param $name
     * @param $callable
     * @return Route
     */
    public function get($name, $callable)
    {
        $path = $this->findPath($name);

        return $this->add($path, $callable, 'GET');
    }

    /**
     * @param $name
     * @param $callable
     * @return Route
     */
    public function post($name, $callable)
    {
        $path = $this->findPath($name);

        return $this->add($path, $callable, 'POST');
    }

    /**
     * @return mixed
     * @throws RouterException
     */
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

    /**
     * @param $name
     * @return null
     */
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
