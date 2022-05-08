<?php

namespace App\Controller;

use App\Core\View;

class Main{

    public function home()
    {
        echo "Welcome";
    }


    public function front()
    {
        $view = new View("contact", "back");
    }

}