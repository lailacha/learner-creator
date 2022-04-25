<?php

namespace App;


// à enlever la partie suivante c'est pour autoriser l'acces à tous les routes
session_start();

//$_SESSION["id"] = 1;
$_SESSION["roles"] = ["admin"];
//
require "conf.inc.php";

//E

function myAutoloader($class)
{
    // $class -> "Core\Security" "Model\User
    $class = str_ireplace("App\\", "", $class);
    // $class -> "Core/Security" "Model/User
    $class = str_replace("\\", "/", $class);
    // $class -> "Core/Security"
    if (file_exists($class . ".class.php")) {
        include $class . ".class.php";
    }
}

spl_autoload_register("App\myAutoloader");

use App\Core\QueryBuilder;
use App\Core\Security;

$fileRoutes = "routes.yml";

if (file_exists($fileRoutes)) {
    $routes = yaml_parse_file($fileRoutes);
} else {
    die("Le fichier de routing n'existe pas");
}

$uri = explode("?", $_SERVER["REQUEST_URI"])[0];

if (!empty($uri) && $uri[-1] === "/" && strlen($uri) > 1){
    $uri = substr($uri, 0,-1);
    header('Location: '.$uri, true, 301);
}

if (empty($routes[$uri]) || empty($routes[$uri]["controller"]) || empty($routes[$uri]["action"])) {
    die("Page 404");
}


if (!Security::checkRoute($routes[$uri])) {
    die("Not Authorized");
}

Security::checkAuth($routes[$uri]);


$controller = ucfirst(strtolower($routes[$uri]["controller"]));
$action = strtolower($routes[$uri]["action"]);


// $uri = /login
// $Controller = User
// $action = login

$controllerFile = "Controller/" . $controller . ".class.php";
if (!file_exists($controllerFile)) {
    die("Le fichier Controller n'existe pas");
}

include $controllerFile;

$controller = "App\\Controller\\" . $controller;
if (!class_exists($controller)) {
    die("La classe n'existe pas");
}

$objectController = new $controller();


if (!method_exists($objectController, $action)) {
    die("La methode n'existe pas");
}

$objectController->$action();


/*
Exemple utilisation querybuilder


echo "<pre>";
$query = new QueryBuilder();

$test = $query->from('user')
    ->where('email = :email')
    ->setParam('email',"oussama.dahbi98@gmail.com")
    ->orderBy("id", "DESC")
    ->fetchAll();


print_r($test);

*/