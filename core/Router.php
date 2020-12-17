<?php
namespace Framework;

use Framework\route\Route;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route as ZendRoute;

class Router
{
    /**
     * @var FastRouteRouter
     */
    private $router;
    
    /**
     * __construct
     *
     * @param  mixed $router
     * @return void
     */
    public function __construct()
    {
        $this->router =  new FastRouteRouter();
    }
    
    /**
     * get
     *
     * @param  mixed $path
     * @param  mixed $callable
     * @param  mixed $name
     * @return void
     */
    public function get(string $path, callable $callable, string $name)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['GET'], $name));
    }
       
    /**
     * match
     *
     * @param  ServerRequestInterface $request
     * @return Route
     */
    public function match(ServerRequestInterface $request): ?Route
    {
        $result = $this->router->match($request);
        if ($result->isSuccess()) {
            return new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedMiddleware(),
                $result->getMatchedParams()
            );
        }
        return null;
    }

    public function generateUrl(string $name, array $params): ?string
    {
        return $this->router->generateUri($name, $params);
    }
}
