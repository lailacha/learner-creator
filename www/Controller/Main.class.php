<?php

namespace App\Controller;

use App\Core\View;
use App\Controller\BaseController;

class Main extends BaseController{

    public function home()
    {
        $view = new View("home", "home");
    }


    public function contact()
    {
        $view = new View("contact", "home");
    }

}