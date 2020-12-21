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
        $this->router  = new Router($request->getUri()->getPath(), $request);
        $this->router->get('/', "Home:index", 'home.index');
        $this->router->get('/posts', "Posts:index", 'posts.index');
        $this->router->get('/post/:slug-:id', "Posts:show", 'post.show')->with('slug', '[a-z-0-9]+')->with('id', '[0-9]+');
        $this->router->post('/post-new-comme/:slug-:id', "Posts:newComment", 'post.comment')->with('slug', '[a-z-0-9]+')->with('id', '[0-9]+');
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
