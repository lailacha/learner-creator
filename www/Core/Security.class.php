<?php

namespace App\Core;

class Security
{

    public static function checkRoute($route): bool
    {
        $security = $route['security'] ?? null;

        $session = new Session();

        $rolesUser = $session->get("roles");

        if (!is_null($security) && !in_array("admin", $rolesUser)) {
            return false;
        }

        return true;
    }


}