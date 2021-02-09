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
    /**
     * Get value into session
     *
     * @param string $key
     * @return void
     */
    public function getSession($key)
    {
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }
        return null;
    }
    /**
     * Set key and value into session
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function setSession(string $key, $value)
    {
        $_SESSION[$key][] = $value;
    }
    /**
     * Delete session
     *
     * @param string $key
     * @return void
     */
    public function deleteSession(string $key)
    {
        unset($_SESSION[$key]);
    }
    /**
     * Set user into session
     *
     * @param Users $user
     * @return void
     */
    public function auth(Users $user)
    {
        $_SESSION['auth'] = $user->getArray();
    }
    /**
     * Logout user
     *
     * @return void
     */
    public function logout()
    {
        $this->deleteSession('auth');
    }
}
