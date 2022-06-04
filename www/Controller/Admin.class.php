<?php

namespace App\Controller;

use App\Core\FormBuilder;
use App\Core\View;
use App\Model\Role;
use App\Model\User as UserModel;

class Admin extends BaseController
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

    public function editUser(): void
    {

        $user = new UserModel();
        $id_user = $this->request->get("id");
        $user = $user->getBy('id', $id_user);


        if ($user) {
            $form = FormBuilder::render($user->getEditUserForm());
            $view = new View("editUser", "back");
            $view->assign("user", $user);
            $view->assign("form", $form);
            if ($_POST) {
                $user = $user->getBy("id", $_POST['id']);
                $user->setEmail($_POST['email']);
                $user->setLastname($_POST['lastname']);
                $user->setFirstname($_POST['firstname']);
                $user->setRoleId($_POST['role']);
                $user->save();

                header('Location: /users');
            }
        } else {
            die("user non trouvable");
        }
    }

}