<?php
namespace Framework\Router;

use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Route class
 * @author nicolas de Fontaine <nicolas.defontaine@apizee.com>
 */
class Route
{
    /**
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

    /**
     * Init route
     *
     * @param string $path
     * @param callable $callable
     * @param Request $request
     */
    public function __construct(string $path, $callable, Request $request)
    {
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
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
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

            $controller  = new $controller();
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
        $uri = $this->request->getUri()->getPath();
        return '/'.$path;
    }
}
