<?php

namespace Framework;

use Framework\Router\Router;
use Framework\Session\Session;
use Framework\Session\SessionFlash;
use Framework\Twig\Twig as Twig;

class Controller
{
    protected $entity;
    protected $twig;
    protected $router;
    protected $container;
    protected $sessionFlash;
    private $session;
    public function __construct(
        Entity $entity,
        Router $router,
        Twig $twig,
        Container $container,
        SessionFlash $sessionFlash,
        Session $session
    ) {
        $this->container = $container;
        $this->entity = $entity;
        $this->twig = $twig;
        $this->router = $router;
        $this->sessionFlash = $sessionFlash;
        $this->session = $session;
    }

    public function renderview(string $vue, array $params = [])
    {
        $params['flashs'] = $this->sessionFlash->getFlash();
      
        echo $this->twig->twig->render($vue, $params);
    }

    public function generateSlug($title)
    {
        $slug = str_replace("'", '-', $title);
        $slug = str_replace(' ', '-', $slug);

        return $slug;
    }

    public function setFlash(array $params)
    {
        $this->sessionFlash->setFlash($params);
    }

    public function getSession()
    {
        return $this->session;
    }
}
