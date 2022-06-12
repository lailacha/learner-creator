<?php


namespace App\Core;

use App\Core\HttpRequest;
use App\Core\Route;


class Router
{

    private $fileRoutes = "routes.yml";
    private $listRoutes;

    public function __construct()
    {

        if (file_exists($this->fileRoutes)) {
            $this->listRoutes = yaml_parse_file($this->fileRoutes);
        } else {
            die("Le fichier de routing n'existe pas");
        }

    }

    public function findRoute(HttpRequest $httpRequest): \App\Core\Route
    {
        $routeFound = array_filter($this->listRoutes,function($route) use ($httpRequest){
            $method = $route["method"] ?? "GET";

             return preg_match("#^" . $route["path"] . "$#", $httpRequest->getUrl()) && $method === $httpRequest->getMethod();
        });
    

        if (!Security::checkRoute(array_values($routeFound)[0])) {

            die("Not Authorized");
        }

        Security::checkAuth($routeFound);

        $numberRoute = count($routeFound);
        if ($numberRoute > 1) {
            throw new MultipleRouteFoundException();
        } else if ($numberRoute == 0) {
            throw new NoRouteFoundException();
        } else {
            return new Route(array_shift($routeFound));
        }

    }


}