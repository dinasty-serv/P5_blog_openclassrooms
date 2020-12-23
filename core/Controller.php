<?php

namespace Framework;

use Framework\Router\Router;
use GuzzleHttp\Psr7\Request;
use \Twig\Environment as Twig;

abstract class Controller
{
    protected $entity;
    protected $twig;
    protected $router;

    public function __construct(Entity $entity, Router $router, Twig $twig)
    {
        $this->entity = $entity;
        $this->twig = $twig;
        $this->router = $router;
    }

    public function renderview(string $vue, array $params = [])
    {
        echo $this->twig->render($vue, $params);
    }
}
