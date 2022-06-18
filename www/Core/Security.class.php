<?php

namespace App\Core;

class Security
{

    public static function checkRoute($route): bool
    {
        $securityRole = $route['security'] ?? null;

        $roleUser = Session::getInstance()->get("role");

      /*  if(!isset($route['security']) || $roleUser === $securityRole)
        {
            return true;
        }
        else
        {
            return false;
        }*/
        return true;

    }

    public
    static function checkAuth($route): void
    {
        $auth = $route['auth'] ?? null;
        $idUser = Session::getInstance()->get("id");

        if (!is_null($auth) && is_null($idUser)) {
            header('Location: /login', true, 302);
            header('Connection: close');
        }

    }


}