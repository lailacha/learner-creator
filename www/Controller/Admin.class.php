<?php

namespace App\Controller;

use App\Core\View;
use App\Model\User as UserModel;

class Admin
{


    public function home(): void
    {
        //Connecté à la bdd
        //j'ai récup le prenom
        $firstname = "Yves";

        $view = new View("dashboard", "back");
        $view->assign("firstname", $firstname);
        $view->assign("lastname", "SKRZYPCZYK");
    }


    public function users(): void
    {
        $user = new UserModel();
        $listUsers = $user->getAllUsers();

        $action = explode("/", $_SERVER["REQUEST_URI"])[2] ?? null;
        $action = explode("?", $action)[0] ?? null;
        $idUser = $_GET['id'] ?? null;


        if ($action === "delete" && !empty($idUser)){
            $user->deleteUser($idUser);
            header('Location: /users');
        }
        elseif ($action === "view" && !empty($idUser)){

        }
        $view = new View("users", "back");
        $view->assign("listUsers", $listUsers);

    }
}