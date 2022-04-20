<?php

namespace App\Core;

class Security
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function getSession(): Session
    {
        return $this->session;
    }

    public function setSession(Session $session): void
    {
        $this->session = $session;
    }


    public static function checkRoute($route): bool
    {
        $security = $route['security'] ?? null;

        $rolesUser = (new Security)->getSession()->get("roles");


        if (!is_null($security) && !in_array($security, $rolesUser, true)) {
            http_response_code(403);
            return false;
        }

        return true;
    }

    public static function checkAuth($route): void
    {
        $auth = $route['auth'] ?? null;
        $idUser = (new Security)->getSession()->get("id") ?? null;

        if (!is_null($auth) && is_null($idUser)) {
            header('Location: /login', true, 302);
            header('Connection: close');
        }

    }


}