<?php

namespace App\Core;


class Route
{
    private string $path;
    private string $controller;
    private string $action;
    private string $method;
    private $param;

    public function __construct($route)
    {
        $this->path = $route["path"];
        $this->controller = $route["controller"];
        $this->action = $route["action"];
        $this->method = $route["method"] ?? "GET";
        $this->param = $route["param"] ?? [];

    }


    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getParam(): array
    {
        return $this->param;
    }

    public function run($httpRequest, $config)
    {
        $controllerFile = "Controller/" . ucfirst($this->controller) . ".class.php";
        if (!file_exists($controllerFile)) {
            die("Le fichier Controller n'existe pas");
        }

        include $controllerFile;
        $controller = "App\\Controller\\" . $this->controller;
        

        if (class_exists($controller)) {
            $controller = new $controller($httpRequest, $this, new Session());
            if (method_exists($controller, $this->action)) {

                $httpRequest->bindParam();
                $controller->getSession()->ensureStarted();
                $controller->{$this->action}();
            } else {
                throw new ActionNotFoundException();
            }
        } else {
            die("La classe Controller n'existe pas");
        }

    }

    public function redirect($url)
    {
        header("Location: " . $url);
    }

    public function goBack()
    {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }

}