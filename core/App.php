<?php
namespace Framework;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\config\Config;
use Framework\bdd;
use Framework\Exception;
use Framework\Entity;
class App
{
    protected $bdd;
    protected $config;
    protected $exeption;
    protected $entity;

    public function __construct()
    {
        $this->config = new Config();
        $this->bdd = new bdd($this->config->getDatabaseConfig(), $this->config->getPathsEntityConfig());
        $this->entity = new Entity();
    }

    public function run()
    {
        var_dump($this->bdd->getAll('posts'));
    }
}
