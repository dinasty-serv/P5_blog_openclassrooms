<?php
namespace Framework\Session;

class SessionFlash
{
    private $session;

    // const TYPE = 'flash';


    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function setFlash(array $params)
    {
        $this->session->setSession('flash', $params);
    }

    public function getFlash()
    {
        $flash =  $this->session->getSession('flash');
        $this->session->deleteSession('flash');
        return $flash;
    }
}
