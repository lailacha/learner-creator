<?php

namespace App\Controller;

use App\Core\FormBuilder;
use App\Core\View;
use App\Model\User as UserModel;

class Admin
{


    public function home(): void
    {

        $firstname = "Yves";

        $view = new View("dashboard", "back");
        $view->assign("firstname", $firstname);
        $view->assign("lastname", "SKRZYPCZYK");
    }


    public function users(): void
    {
        $user = new UserModel();
        $listUsers = $user->getAllUsers();

        $view = new View("users", "back");
        $view->assign("listUsers", $listUsers);
    }

}