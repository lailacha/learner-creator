<?php
namespace App;

require "conf.inc.php";
use App\Core\HttpRequest;
use App\Core\Router;

//E

function myAutoloader( $class )
{
    // $class -> "Core\Security" "Model\User
    $class = str_ireplace("App\\","",$class);
    // $class -> "Core/Security" "Model/User
    $class = str_replace("\\","/",$class);
    // $class -> "Core/Security"
    if(file_exists($class.".class.php")){
        include $class.".class.php";
    }
}

spl_autoload_register("App\myAutoloader");



try
{
    $config = yaml_parse_file("routes.yml");
    $httpRequest = new HttpRequest();
    $router = new Router();
    $httpRequest->setRoute($router->findRoute($httpRequest));
    //route is a srring

   $httpRequest->run($config);

}
catch(Exception $e)
{
    echo "Une erreur s'est produite";
}
