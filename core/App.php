<?php
namespace Framework;

use Psr\Http\Message\ServerRequestInterface;
use Framework\config\Config;
use Framework\Entity;
use Framework\Router\Router;
use Framework\Router\RouterTwigExtention;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface as Response;

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
   

    

    public function __construct()
    {
        $this->config = new Config();
        $this->entity = new Entity($this->config);
        $this->initRouter(ServerRequest::fromGlobals());
        $this->twig = $this->initTwig();
    }

    public function run()
    {
        $this->router->run();
    }
   
    public function initRouter(ServerRequestInterface $request)
    {
        $uri = $request->getUri()->getPath();
        
        
        $this->router  = new Router($uri);
        $this->router->get('/', "Home:index", 'home.index', $request);
        $this->router->get('/posts', "Posts:index", 'posts.index', $request);
        $this->router->get('/post/:slug-:id', "Posts:show", 'post.show', $request)->with('slug', '[a-z-0-9]+')->with('id', '[0-9]+');
        $this->router->post('/post-new-comme/:slug-:id', "Posts:newComment", 'post.comment', $request)->with('slug', '[a-z-0-9]+')->with('id', '[0-9]+');
    }

    /**
     * Init twig
     *
     * @return object
     */
    private function initTwig()
    {
        $loader = new \Twig\Loader\FilesystemLoader($this->config->getPathsViewConfig());
        $twig =  new \Twig\Environment($loader);

        $twig->addExtension(new RouterTwigExtention($this->router));

        return $twig;
    }
}
