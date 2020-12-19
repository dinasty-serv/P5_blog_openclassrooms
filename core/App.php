<?php
namespace Framework;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\config\Config;
use Framework\bdd;
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
        $this->bdd = new bdd($this->config->getDatabaseConfig(), $this->config->getPathsEntityConfig());
        $this->entity = new Entity();
        $this->router  = new Router($_GET['url']);

        $this->twig = $this->initTwig();
    }

    public function run()
    {
        $this->getRoutes();
        $this->router->run();
    }

    public function getRoutes(){

       $this->router->get('/', "Home:index", 'Home.index');
       
       $this->router->get('/post/:slug-:id', "Posts:show", 'posts.show')->with('slug', '[a-z0-9]+')->with('id', '[0-9]+');

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
            $loader,
            [
            
            ]
        );
    }
}
