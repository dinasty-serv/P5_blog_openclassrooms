<?php
namespace Framework;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\config\Config;
use Framework\bdd;
use Framework\Exception;

class App
{
    protected $bdd;
    private $config;
    protected $exeption;

    public function __construct()
    {
        $this->config = new Config();
        $this->bdd = new bdd($this->config->getDatabaseConfig(), $this->config->getPathsEntityConfig());
    }

    public function run()
    {
        $this->bdd->getPathEntity('posts');
    }
}
