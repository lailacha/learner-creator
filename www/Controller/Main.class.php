<?php

namespace App\Controller;

use App\Core\View;
use App\Controller\BaseController;

class Main extends BaseController{

    public function home()
    {
        echo "Welcome";
    }


    public function front()
    {
        $view = new View("contact", "back");
    }

}