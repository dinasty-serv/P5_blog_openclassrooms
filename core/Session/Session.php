<?php
namespace Framework\Session;

use App\Entity\Users;

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

    public function setSession(string $key, $value)
    {
        $_SESSION[$key][] = $value;
    }

    public function deleteSession(string $key)
    {
        unset($_SESSION[$key]);
    }

    public function auth(Users $user)
    {
        $_SESSION['auth'] = $user->getArray();
    }

    public function logout()
    {
        $this->deleteSession('auth');
    }
}
