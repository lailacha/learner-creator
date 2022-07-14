<?php


namespace App\Controller;

use App\Core\HttpRequest;
use App\Core\Route;
use App\Core\Session;
use App\Core\View;

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

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->session;
    }

    public function abort(?int $code = 404, ?string $message = null) : void
    {
        http_response_code($code);
        if($message !== null) {
            $this->session->addFlashMessage("error", $message);
        }

        $view = new View($code, "front");
    }

}