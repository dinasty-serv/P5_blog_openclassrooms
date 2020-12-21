<?php
namespace Framework;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\config\Config;
use Framework\Database\Bdd;
use Framework\Exception;
use Framework\Entity;
use Twig\TwigTest;
use Framework\Router\Router;
use Framework\Router\RouterTwigExtention;

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
    protected $config;

    protected $entity;
    protected $twig;
    public $router;

    

    public function __construct()
    {
        $this->config = new Config();
        $this->router  = new Router($_GET['url']);
        $this->twig = $this->initTwig();
        $this->entity = new Entity($this->config);
        $this->getRoutes();
    }

    public function run()
    {
        $this->router->run();
    }
    /**
     * Cread Route
     *
     * @todo   A déplacer
     * @return null
     */
    public function getRoutes()
    {
        $this->router->get('/', "Home:index", 'home.index');
        $this->router->get('/posts', "Posts:index", 'posts.index');
        $this->router->get('/post/:slug-:id', "Posts:show", 'post.show')->with('slug', '[a-z-0-9]+')->with('id', '[0-9]+');
        $this->router->post('/post-new-comme/:slug-:id', "Posts:show", 'post.comment')->with('slug', '[a-z-0-9]+')->with('id', '[0-9]+');
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
