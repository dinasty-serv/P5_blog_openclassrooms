<?php
namespace Framework;

use Psr\Http\Message\ServerRequestInterface;
use Framework\config\Config;
use Framework\Entity;
use Framework\Router\Router;
use Framework\Router\RouterTwigExtention;
use GuzzleHttp\Psr7\ServerRequest;

class App
{
    /**
     * Mysql instance
     *
     * @var Object
     */
    protected $bdd;
    /**
     * Config instance
     *
     * @var Object
     */
    public $config;
    public $entity;
    public $twig;
    public $router;
    public $container;
   

    

    public function __construct()
    {
        $this->container = new Container();
        $this->initRouter(ServerRequest::fromGlobals());
    }

    public function run()
    {
        $this->router->run();
    }
   
    public function initRouter(ServerRequestInterface $request)
    {
        $uri = $request->getUri()->getPath();
        
        
        $this->container->get(new Router($uri, $request, $this->container));
       

        $this->router->get('/', "Home:index", 'home.index');
        $this->router->get('/posts', "Posts:index", 'posts.index');
        $this->router->get('/post/:slug-:id', "Posts:show", 'post.show')->with('slug', '[a-z-0-9]+')->with('id', '[0-9]+');
        $this->router->post('/post-new-comme/:slug-:id', "Posts:newComment", 'post.comment')->with('slug', '[a-z-0-9]+')->with('id', '[0-9]+');
    }
}
