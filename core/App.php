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
    }

    public function run()
    {
        $this->getRoutes();
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
        $this->router->get('/', "Home:index", 'Home.index');
        $this->router->get('/posts', "Posts:index", 'Posts.index');

       
        $this->router->get('/post/:slug-:id', "Posts:show", 'posts.show')->with('slug', '[a-z-0-9]+')->with('id', '[0-9]+');
        $this->router->post('/post/:slug-:id', "Posts:show", 'posts.show')->with('slug', '[a-z-0-9]+')->with('id', '[0-9]+');
    }

    /**
     * Init twig
     *
     * @return object
     */
    private function initTwig()
    {
        $loader = new \Twig\Loader\FilesystemLoader($this->config->getPathsViewConfig());
        return new \Twig\Environment(
            $loader
        );
    }
}
