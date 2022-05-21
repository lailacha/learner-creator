<?php

namespace App\Controller;

use App\Core\View;
use App\Controller\BaseController;

class Admin extends BaseController{


    public function home()
    {
        //Connecté à la bdd
        //j'ai récup le prenom
        $firstname = "Yves";

        $view = new View("dashboard", "back");
        $view->assign("firstname", $firstname);
        $view->assign("lastname", "SKRZYPCZYK");
    }


}