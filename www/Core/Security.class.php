<?php

namespace App\Core;

class Security
{

    public static function checkRoute($route): bool
    {
        $session = new Session();

        $roleUser = $session->get("role");

        $security = $route['security'] ?? null;

        if (!is_null($security) && $roleUser != 'admin') {
            return false;
        }

        return true;
    }


}