<?php

namespace App;

require "conf.inc.php";
use App\Core\HttpRequest;
use App\Core\Router;
use App\Core\SQL;
use App\Core\QueryBuilder;
use App\Core\Security;
use App\Core\Session;
use App\Model\Settings;


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

use App\Core\MysqlBuilder;
use App\Core\QueryBuilder;
use App\Core\Security;




try
{
    $session = Session::getInstance();
    $session->ensureStarted();
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

$objectController->$action();



//Exemple utilisation MysqlBuilder


echo "<pre>";
$query = new MysqlBuilder();

$test = $query->from('esgi_file')
    ->where('extension = :extension')
    ->setParam('extension',"jpeg")
    ->orderBy("id", "ASC")
    ->fetchAll();


print_r($test);

