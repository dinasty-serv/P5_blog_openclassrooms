<?php

namespace Framework\Twig;

use Framework\config\Config;
use Framework\Router\Router;

class Twig
{
    private $config;
    public $twig;
    private $router;
    /**
       * Init twig
       *
       * @param Config $config
       * @param Router $router
       */
  
    public function __construct(Config $config, Router $router)
    {
        $this->config = $config;
        $this->router = $router;

        $loader = new \Twig\Loader\FilesystemLoader($this->config->getPathsViewConfig());
        $this->twig =  new \Twig\Environment($loader, ['debug' => true]);
        $this->twig->addExtension(new RouterTwigExtention($this->router));
        $this->twig->addExtension(new \Twig_Extensions_Extension_Text());
    }
}
