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
    /**
     * Constructor controller
     *
     * @param Entity $entity
     * @param Router $router
     * @param Twig $twig
     * @param Container $container
     * @param SessionFlash $sessionFlash
     * @param Session $session
     */
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

        if ($this->session->getSession('auth') !== null) {
            $this->user = $this->entity->getEntity('users')->findOneBy([
                'id' => $this->session->getSession('auth')['id']
                ]);
        }
    }
    /**
     * Render view for twig
     *
     * @param string $vue
     * @param array $params
     * @return void
     */
    public function renderview(string $vue, array $params = [])
    {
        $params['flashs'] = $this->sessionFlash->getFlash();
        $params['auth'] = $this->session->getSession('auth');
        $params['csrf_token'] = $this->session->getSession('csrf_token')[0];

        echo $this->twig->twig->render($vue, $params);
    }
    /**
     * Generate slug for post
     *
     * @param string $title
     * @return void
     */
    public function generateSlug($title)
    {
        $slug = str_replace("'", '-', $title);
        $slug = str_replace(' ', '-', $slug);

        return $slug;
    }
    /**
     * Set message flash
     *
     * @param array $params
     * @return void
     */
    public function setFlash(array $params)
    {
        $this->sessionFlash->setFlash($params);
    }
    /**
     * get Session into controller
     *
     * @return void
     */
    public function getSession()
    {
        return $this->session;
    }
    /**
     * Generate token for password reset
     *
     * @return void
     */
    public function generateToken()
    {
        $token = openssl_random_pseudo_bytes(16);
 
        $token = bin2hex($token);
 
        return $token;
    }
}
