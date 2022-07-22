<?php


namespace App\Core;

use App\Core\HttpRequest;
use App\Core\Route;
use App\Core\View;
use App\Exception\MultipleRouteFoundException;
use App\Exception\NoRouteFoundException;
use App\Model\Course;



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

        $courseManager = new Course();


        $routeFound = array_filter($this->listRoutes,function($route) use ($httpRequest, $courseManager){
            $method = $route["method"] ?? "GET";


            if($method !== $httpRequest->getMethod())
            {
                return false;
            }

           if(preg_match("#^" . $route["path"] . "$#", $httpRequest->getUrl()))
           {
            return true;
           }
           else
              {
                    if(($route["path"]  == "/show/course" && $courseManager->getBySlug($httpRequest->getSlug())))
                    {
                        return true;
                    }

                    if(($route["path"]  == "/show/lesson" && $courseManager->getBySlug($httpRequest->getSlug())))
                    {
                        return true;
                    }

            return false;
            }
        });

        $numberRoute = count($routeFound);
         if ($numberRoute == 0) {
            $view = new View("404");
            die(); ;
        } else {

            Security::checkAuth($routeFound);

        if (!Security::checkRoute(array_values($routeFound)[0])) {

            $view = new View("404");
            die(); ;
        }
            return new Route(array_shift($routeFound));
        }

    }


}