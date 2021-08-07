<?php

namespace Framework\Session;

class SessionFlash
{
    private $session;



    public function __construct(Session $session)
    {
        $this->session = $session;
    }
    /**
     * Set message flash into session
     *
     * @param array $params
     * @return void
     */
    public function setFlash(array $params)
    {
        $this->session->setSession('flash', $params);
    }
    /**
     * Get message flash into session
     *
     * @return void
     */
    public function getFlash()
    {
        $flash =  $this->session->getSession('flash');
        $this->session->deleteSession('flash');
        return $flash;
    }
}
