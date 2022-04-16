<?php


namespace App\Controller;

use App\Core\HttpRequest;
use App\Core\Route;
use App\Core\Session;

class BaseController
{

    protected $request;
    protected $route;
    protected Session $session;

    public function __construct(HttpRequest $request, Route $route, Session $session)
    {
        $this->request = $request;
        $this->route = $route;
        $this->session = $session;
    }   

}