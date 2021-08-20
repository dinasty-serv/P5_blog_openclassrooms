<?php

namespace Framework\Router;

use Framework\Container;
use Framework\Csrf;
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
    private string $url;
    /**
    * Array for routes
    * @var array
    */
    private array $routes = [];
    /**
    * Array for routesName
    * @var array
    */
    private array $routeName = [];
    /**
     * Request
     *
     * @var Request $request
     */
    private Request $request;

    private Container $container;


    /**
     * Init Router
     * @param Request $request
     * @param Container $container
     */

    public function __construct(Request $request, Container $container)
    {
        $this->container = $container;
        $this->request = $request;
        $uri = $this->request->getUri()->getPath();

        $this->url = $uri;
    }


    /**
     * Init new route GET
     *
     * @param string $path
     * @param string $callable
     * @param string|null $name
     * @return Route
     */
    public function get(string $path, string $callable, string $name = null): Route
    {
        return $this->addRoute($path, $callable, $name, 'GET');
    }

    /**
     * Init new route Post
     *
     * @param string $path
     * @param string $callable
     * @param string|null $name
     * @return Route
     */
    public function post(string $path, string $callable, string $name = null): Route
    {
        return $this->addRoute($path, $callable, $name, 'POST');
    }

    /**
     * Add new route into Array
     *
     * @param string $path
     * @param string $callable
     * @param string|null $name
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
     * @return void
     * @throws Exception|\ReflectionException
     */
    public function run()
    {
        if (!isset($this->routes[$this->request->getMethod()])) {
            throw new Exception('REQUEST_METHOD does not exist');
        }
        if ($this->request->getMethod() == "POST") {
            $csrf = $this->container->get(Csrf::class);
            $csrf->checkToken($this->request);
        }
        foreach ($this->routes[$this->request->getMethod()] as $route) {

            if ($route->match($this->url)) {

                    return $route->call();




            }
        }
        throw new Exception('No matching routes for ' . $this->url);

    }

    /**
     * Generate URL for route name and params
     *
     * @param string $name
     * @param array $params
     * @param bool $absolut
     * @return string
     * @throws Exception
     */
    public function url(string $name, array $params = [], bool $absolut = false): string
    {
        if (!isset($this->routeName[$name])) {
            throw new Exception('No route matches this name');
        }
        return $this->routeName[$name]->getUrl($params, $absolut);
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
        header("Location:" . $this->request->getServerParams()['REQUEST_SCHEME'] . "://" . $this->request->getServerParams()['SERVER_NAME'] . ":" . $this->request->getServerParams()['SERVER_PORT'] . "" . $url);
    }
}
