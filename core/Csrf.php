<?php
namespace Framwork;

use Framework\Session\Session;
use GuzzleHttp\Psr7\ServerRequest as Request;
use Framework\Exception;

Class Csrf{

    private $token;

    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
        if(empty($this->token)){
            $this->token = $this->generateToken();
        }
    }

    public function getToken(){
        
            return $this->session->getSession('csrf_token');
      
    }

    public function setToken(){
        $this->session->setSession('csrf_token', $this->token);
    }

    private function generateToken(){

    }

    public function checkToken(Request $request)
    {
        $data =  $request->getParsedBody();

        if (!isset($data['csrf_token']) && $data['csrf_token'] != $this->session->getSession('csrf_token')){
            throw new Exception('Invalid csrf token');
        }

    }
}