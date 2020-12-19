<?php
namespace Framework\Router;

use Framework\App;
use Framework\Exception;

class Router
{
    private $url;
    private $routes = [];
    private $routeName = [];


    public function __construct($url)
    {
        $this->url = $url;
    }

    
    public function get($path, $callable, $name = null):Route
    {
        return $this->addRoute($path, $callable, $name, 'GET');
    }

    public function post($path, $callable, $name = null):Route
    {
        return $this->addRoute($path, $callable, $name, 'POST');
    }

    public function addRoute($path, $callable, $name = null, $methode)
    {
        $route = new Route($path, $callable);

        $this->routes[$methode][] = $route;

        if ($name) {
            $this->routeName[$name] = $route;
        }

        return $route;
    }

    public function run():Route
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new Exception('REQUEST_METHOD does not exist');
        }

        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                return $route->call();
            }
        }
        throw new Exception('No matching routes');
    }

    public function url(string $name, array $params = [])
    {
        if (!isset($this->routeName[$name])) {
            throw new Exception('No route matches this name');
        }
        return $this->routeName[$name]->getUrl($params);
    }
}
