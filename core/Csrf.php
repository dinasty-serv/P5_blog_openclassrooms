<?php

namespace Framework;

use Framework\Session\Session;
use GuzzleHttp\Psr7\ServerRequest as Request;
use Framework\Exception;

class Csrf
{
    private $token;

    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
        if (empty($this->session->getSession('csrf_token')[0])) {
            $this->token = $this->generateToken();
            $this->setToken();
        }
    }
    /**
     * get csrf token into session
     *
     * @return void
     */
    public function getToken()
    {
        return $this->session->getSession('csrf_token');
    }
    /**
     * Set csrf token into session
     *
     * @return void
     */
    public function setToken()
    {
        $this->session->setSession('csrf_token', $this->token);
    }
    /**
     * Generate CSRF token
     *
     * @return string
     */
    private function generateToken()
    {
        $token = openssl_random_pseudo_bytes(16);
 
        $token = bin2hex($token);
        return $token;
    }
    /**
     * Check token if request is post
     *
     * @param Request $request
     * @return void
     */
    public function checkToken(Request $request)
    {
        $data =  $request->getParsedBody();
       
        if (isset($data['csrf_token'])) {
            if ($data['csrf_token'] != $this->session->getSession('csrf_token')[0]) {
                throw new Exception('Invalid csrf token 1');
            }
        } else {
            throw new Exception('Invalid csrf token 2');
        }
    }
}
