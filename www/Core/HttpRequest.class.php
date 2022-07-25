<?php


namespace App\Core;


use InvalidArgumentException;

class HttpRequest
{
    private $url;
    private $method;
    private $param;
    private $data;

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }
    private $route;


    public function __construct()
    {
        $this->url = explode("?", $_SERVER["REQUEST_URI"])[0];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->param = [];

    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }


    public function getSlug()
    {
        return basename(parse_url($this->url, PHP_URL_PATH));
    }


    public function bindParam()
    {
        switch($this->method)
        {
            case "GET":
            case "DELETE":
            foreach($this->route->getParam() as $param)
            {
                if(isset($_GET[$param] ))
                {
                    $this->param[] = htmlspecialchars($_GET[$param]);
                    $this->data[$param] = htmlspecialchars($_GET[$param]) ;
                }

                if(isset($_FILES[$param]))
                {
                    $this->param[] = $_FILES[$param];
                    $this->data[$param] = $_FILES[$param];
                }
            }
            case "POST":
            case "PUT":
                foreach($this->route->getParam() as $param)
                {
                    if(isset($_POST[$param] ))
                    {
                        $this->param[] = htmlspecialchars($_POST[$param]) ;
                        $this->data[$param] = htmlspecialchars($_POST[$param]);
                    }

                    if(isset($_FILES[$param]))
                    {
                        $this->param[] = $_FILES[$param];
                        $this->data[$param] = $_FILES[$param];
                    }
                }
        }
    }


    public function run($config){
        $this->route->run($this,$config);
    }
    
    
    public function get(string $param){
        if(!isset($this->data[$param])) {
            return null;
            throw new InvalidArgumentException("Cannot access data. Il n'y a pas de paramètre existant pour " . $param . " dans les paramètre de la route. Veuillez verifier");
        }
        return $this->data[$param];
    }





}