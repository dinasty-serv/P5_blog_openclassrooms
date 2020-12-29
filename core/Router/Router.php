<?php
namespace Framework\Router;

use Framework\Container;
use Framework\Exception;
use GuzzleHttp\Psr7\ServerRequest as Request;

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
     * Request
     *
     * @var Request $request
     */
    private $request;

    private $container;
    

    /**
     * Init Router
     * @param string  $url
     * @param Request $request
     */

    public function __construct(Request $request, Container $container)
    {
        $this->container = $container;
        $this->request = $request;
        $uri = $this->request->getUri()->getPath();

        $this->url = $uri;

        
        
      
        //var_dump($this->url);
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
    public function get(string $path, string $callable, string $name = null)
    {
        return $this->addRoute($path, $callable, $name, 'GET');
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
    public function post(string $path, string $callable, string $name = null):Route
    {
        return $this->addRoute($path, $callable, $name, 'POST');
    }

    /**
     * Add new route into Array
     *
     * @param string $path
     * @param string $callable
     * @param string $name
     * @param string $methode
     * @return Route
     */
    public function addRoute(string $path, string $callable, string $name = null, string $methode): Route
    {
        $route = new Route($path, $callable, $this->request, $this->container);

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
        if (!isset($this->routes[$this->request->getMethod()])) {
            throw new Exception('REQUEST_METHOD does not exist');
        }
        foreach ($this->routes[$this->request->getMethod()] as $route) {
            if ($route->match($this->url)) {
                return $route->call();
            }
        }
       
        throw new Exception('No matching routes for '.$this->url);
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
    /**
     * Redirect to route
     *
     * @param string $name
     * @param array|null $params
     * @return void
     */
    public function redirect(string $name, ?array $params = [])
    {
        if (!isset($this->routeName[$name])) {
            throw new Exception('No route matches this name');
        }
        $url = $this->url($name, $params);
        header("Location:".$this->request->getServerParams()['REQUEST_SCHEME']."://".$this->request->getServerParams()['SERVER_NAME'].":".$this->request->getServerParams()['SERVER_PORT']."".$url);
    }
}
