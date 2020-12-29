<?php

namespace Framework;

use Framework\Router\Router;
use Framework\Twig\Twig as Twig;

class Controller
{
    protected $entity;
    protected $twig;
    protected $router;
    protected $container;
    public function __construct(Entity $entity, Router $router, Twig $twig, Container $container)
    {
        $this->container = $container;
        $this->entity = $entity;
        $this->twig = $twig;
        $this->router = $router;
    }

    public function renderview(string $vue, array $params = [])
    {
        echo $this->twig->twig->render($vue, $params);
    }
}
