<?php
namespace Framework\Session;

class Session
{
    /**
     * Session
     *
     * @var array
     */


    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function getSession($key)
    {
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }
        return null;
    }

    public function setSession(string $key, array $value)
    {
        $_SESSION[$key][] = $value;
    }

    public function deleteSession(string $key)
    {
        unset($_SESSION[$key]);
    }
}
