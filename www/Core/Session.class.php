<?php


namespace App\Core;


class Session
{
    public function ensureStarted()
    {
            if(session_status() === PHP_SESSION_NONE){
                session_start();
            }

    }

    public function get(string $key, $default = null)
    {
        $this->ensureStarted();
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

    public function delete(string $key): void
    {
        $this->ensureStarted();
        unset($_SESSION[$key]);
    }
}