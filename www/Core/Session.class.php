<?php


namespace App\Core;


class Session
{

    public static function get(string $key, $default = null)
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

    public static function delete(string $key): void
    {
        unset($_SESSION[$key]);
    }


    //function to add session flash messages
    public function addFlash(string $key, $value = null): void
    {
        $_SESSION[$key] = $value;
    }

}