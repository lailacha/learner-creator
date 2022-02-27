<?php


namespace App\Controller;

use App\Core\HttpRequest;

class BaseController
{

    protected $request;

    public function __construct(HttpRequest $request)
    {
        $this->request = $request;

    }

}