<?php
namespace Framework\Router;

use Framework\Entity;
use Psr\Http\Message\ServerRequestInterface as Request;
use Framework\Twig\Twig;
use Framework\Container;
use Framework\Session\Session;
use Framework\Session\SessionFlash;

/**
 * Route class
 * @author nicolas de Fontaine <nicolas.defontaine@apizee.com>
 */
class Route
{
    /*
     * path target
     *
     * @var string $path
     */
    private $path;
    /**
     * Function target
     *
     * @var callable
     */
    private $callable;
    /**
     * Reoute matched
     *
     * @var array
     */
    private $matches = [];
    /**
     * Route params
     *
     * @var array
     */
    private $params = [];
    /**
     * Request
     *
     * @var Request
     */
    private $request;
    private $container;
    


    /**
     * Init route
     *
     * @param string $path
     * @param callable $callable
     * @param Request $request
     */
    public function __construct(string $path, $callable, Request $request, Container $container)
    {
        $this->container = $container;
        $this->path = trim($path, '/');
        $this->callable = $callable;
        $this->request = $request;
    }
    /**
     * Check url matche route
     *
     * @param string $url
     * @return bool
     */
    public function match(string $url):bool
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        $explode = explode('/', $url);

        $prefix = $explode[0];
        
        if ($this->checkAuthoriz($prefix)) {
            if (!preg_match($regex, $url, $matches)) {
                return false;
            }
            array_shift($matches);
            $this->matches = $matches;
            return true;
        } else {
            return false;
        }
    }
    /**
     * Check params matche into route
     *
     * @param string $match
     * @return void
     */
    private function paramMatch($match):string
    {
        if (isset($this->params[$match[1]])) {
            return '('.$this->params[$match[1]].')';
        }
        return '([^/]+)';
    }
    /**
     * Call to action into controller
     *
     * @return void
     */
    public function call()
    {
        if (is_string($this->callable)) {
            $params = explode(':', $this->callable);
            $controller = "App\\Controller\\".$params[0]."Controller";
            $controller  = new $controller(
                $this->container->get(Entity::class),
                $this->container->get(Router::class),
                $this->container->get(Twig::class),
                $this->container,
                $this->container->get(SessionFlash::class),
                $this->container->get(Session::class)
            );
            $this->matches[] = $this->request;
            
            return call_user_func_array([$controller, $params[1]], $this->matches);
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }

    /**
     * set with param
     *
     * @param string $param
     * @param string $regex
     * @return void
     */
    public function with(string $param, string $regex):self
    {
        $this->params[$param] = str_replace('(', '(?:', $regex);

        return $this;
    }
    /**
     * Return URL
     *
     * @param array $params
     * @return string
     */
    public function getUrl(array $params):string
    {
        $path = $this->path;
       
        foreach ($params as $k => $v) {
            $path = str_replace(":$k", $v, $path);
        }
        
        return '/'.$path;
    }

    public function checkAuthoriz($prefix)
    {
        $session = $this->container->get(Session::class);
        $user = $session->getSession('auth');

        if ($prefix === "admin" || $prefix === "membre" && $user != null) {
            if ($prefix === "admin" && $user['role'] === "Admin") {
                return true;
            } else {
                return false;
            }
            return true;
        }

        return true;
    }
}
