<?php
class SessionController
{
    public static function initializeSessionManager()
    {
        session_start();
    }

    public static function isLoggedIn()
    {
        return (isset($_SESSION["LoggedIn"]) && $_SESSION["LoggedIn"]);
    }

    public static function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }

    public static function get($key)
    {
        return $_SESSION[$key];
    }

    public static function killSession()
    {
        session_destroy();
    }
}