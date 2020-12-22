<?php
namespace Framework\Router;

use Framework\App;
use Framework\Exception;

class Router
{
    /**
     * Url enter request
     * @var string
     */
    private $url;
     /**
     * Array for routes
     * @var Array
     */
    private $routes = [];
     /**
     * Array for routesName
     * @var Array
     */
    private $routeName = [];
 

     /**
      * Init Router
      * @param string  $url
      * @param Request $request
      */
    public function __construct($url)
    {
        var_dump($url);
       
        $this->url = $url;
    }

    /**
     * Init new route
     * @param strig $path 
     * @param callback $callable
     * @param string $name
     */
    public function get($path, $callable, $name = null, $request):Route
    {
        return $this->addRoute($path, $callable, $name,$request, 'GET');
    }

    public function post($path, $callable, $name = null, $request):Route
    {
        return $this->addRoute($path, $callable, $name,$request, 'POST');
    }

    public function addRoute($path, $callable, $name = null,$request, $methode)
    {
        $route = new Route($path, $callable, $request);

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
