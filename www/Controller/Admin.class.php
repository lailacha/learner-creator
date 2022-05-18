<?php

namespace App\Controller;

use App\Core\FormBuilder;
use App\Core\View;
use App\Model\RequestTeacher;
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

        $action = $_POST['_method'] ?? null;
        $idUser = $_POST['id_user'] ?? null;


        if ($action === "delete" && !empty($idUser)){
            $user->deleteUser($idUser);
            header('Location: /users');
        }
        elseif ($action === "edit" && !empty($idUser)){
            header('location: /editUser?id='.$idUser);
        }
        $view = new View("users", "back");
        $view->assign("listUsers", $listUsers);

    }


    public function editUser(): void
    {
        $idUser = $_GET['id'] ?? null;
        $user = new UserModel();
        $user = $user->getBy('id',$idUser);
        if ($user){
            $form = FormBuilder::render($user->getEditUserForm());
            $view = new View("editUser", "back");
            $view->assign("user", $user);
            $view->assign("form", $form);
            if ($_POST){
                $user = $user->getBy("id", $_POST['id']);
                $user->setEmail($_POST['email']);
                $user->setLastname($_POST['lastname']);
                $user->setFirstname($_POST['firstname']);
                $user->save();

                header('Location: /users');

            }
        }
        else{
            die("user non trouvable");
        }
    }

    public function requestTeachers()
    {
        $requestManager = new RequestTeacher();
        $listRequestsTeacher = $requestManager->getAllRequestInProgress();
        $view = new View("requestTeachers","back");
        $view->assign("listRequestsTeacher", $listRequestsTeacher);

    }
}