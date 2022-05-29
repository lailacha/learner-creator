<?php


namespace App\Core;


class Session
{

    private static $instance;

    public static function getInstance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function ensureStarted()
    {
            if(session_status() === PHP_SESSION_NONE){
                session_start();
                $_SESSION['role'] = 'admin';
            }

    }

    public function get(string $key, $default = null)
    {
        if(array_key_exists($key, $_SESSION))
        {
            return $_SESSION[$key];
        }
        else
        {
            return $default;
        }

    }

    public function set(string $key, $value = null): void
    {
        $this->ensureStarted();
        $_SESSION[$key] = $value;
    }

    public function addFlashMessage(string $key, $value = null): void
    {
        $this->ensureStarted();
        $_SESSION["flash-message"][$key] = $value;
    }


    public function delete(string $key): void
    {
        $this->ensureStarted();
        unset($_SESSION[$key]);
    }
}