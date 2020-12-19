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
    protected $router;

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
            'cache' => $this->config->getGlobalPath().'/cache/twig',
            ]
        );
    }
}
