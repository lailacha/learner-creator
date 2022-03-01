<?php

namespace App\Controller;

use App\Core\View;

class Main{

    public function home()
    {
        $view = new View("dashboard-back", "back");

    }


    public function contact()
    {
        $view = new View("contact");
    }
}