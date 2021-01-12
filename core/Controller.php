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
    protected $session;
    protected $user;
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

        if ($this->session->getSession('auth') != null) {
            $this->user = $this->entity->getEntity('users')->findOneBy([
                'id' => $this->session->getSession('auth')['id']
                ]);
        }
    }

    public function renderview(string $vue, array $params = [])
    {
        $params['flashs'] = $this->sessionFlash->getFlash();
        $params['auth'] = $this->session->getSession('auth');
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

    public function generateToken()
    {
        $token = openssl_random_pseudo_bytes(16);
 
        $token = bin2hex($token);
 
        return $token;
    }
}
