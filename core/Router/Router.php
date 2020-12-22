<?php
namespace Framework\Router;

use Framework\App;
use Framework\Exception;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Router class
 * @author Nicolas de Fontaine <nicolas.defontaine@apizee.com>
 */
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
     * Init new route GET
     *
     * @param string $path
     * @param string $callable
     * @param string $name
     * @param Request $request
     * @return Route
     */
    public function get(string $path, string $callable, string $name = null, Request $request):Route
    {
        return $this->addRoute($path, $callable, $name, $request, 'GET');
    }
    /**
     * Init new route Post
     *
     * @param string $path
     * @param string $callable
     * @param string $name
     * @param Request $request
     * @return Route
     */
    public function post(string $path, string $callable, string $name = null, Request $request):Route
    {
        return $this->addRoute($path, $callable, $name, $request, 'POST');
    }

    /**
     * Add new route into Array
     *
     * @param string $path
     * @param string $callable
     * @param string $name
     * @param Request $request
     * @param string $methode
     * @return Route
     */
    public function addRoute(string $path, string $callable, string $name = null, Request $request, string $methode): Route
    {
        $route = new Route($path, $callable, $request);

        $this->routes[$methode][] = $route;

        if ($name) {
            $this->routeName[$name] = $route;
        }

        return $route;
    }
    /**
     * Execute route
     *
     * @return Route
     */
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
    /**
     * Generate URL for route name and params
     *
     * @param string $name
     * @param array $params
     * @return string
     */
    public function url(string $name, array $params = []):string
    {
        if (!isset($this->routeName[$name])) {
            throw new Exception('No route matches this name');
        }
        return $this->routeName[$name]->getUrl($params);
    }
}
