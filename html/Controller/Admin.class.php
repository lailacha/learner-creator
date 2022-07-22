<?php

namespace App\Controller;

use App\Core\FormBuilder;
use App\Core\Session;
use App\Core\View;
use App\Model\File;
use App\Model\RequestTeacher;
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
        $id_user = $this->request->get("user_id");
        $user = $user->getBy('id', $id_user);


        if ($user) {
            $form = FormBuilder::render($user->getEditUserForm());
            $view = new View("editUser", "back");
            $view->assign("user", $user);
            $view->assign("form", $form);
            if ($_POST) {
                $user = $user->getBy("id", $_POST['user_id']);
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



    public function requestTeachers(): void
    {
        $requestManager = new RequestTeacher();
        $listRequestsTeacher = $requestManager->getAllRequest();
        $view = new View("requestTeachers", "back");
        $view->assign("listRequestsTeacher", $listRequestsTeacher);
    }

    public function download(): void
    {
        $file_id = $this->request->get("id");
        $file = new File();
        $file = $file->getBy("id", $file_id);
        $path = __DIR__ . "/.." . $file->getPath();

        $file->download();

    }

    public function showRequestTeacher(): void
    {
        $requestManager = new RequestTeacher();
        $id_request = $this->request->get("id");
        $request = $requestManager->getBy("id", $id_request);
        $view = new View("showRequestTeacher", "back");
        $view->assign("request", $request);
    }


    public function validRequestTeacher(): void
    {
        $requestManager = new RequestTeacher();
        $id_request = $this->request->get("id");
        $requestManager = $requestManager->setId($id_request);
        $id_user = $requestManager->getUserId();
        $user = new UserModel();
        $user = $user->setId($id_user);
        $user->setRoleId(2);
        $user->save();
        $requestManager->setStatut(1);
        $requestManager->save();
        header('Location: /teachers/allRequests');
        $session = Session::getInstance();
        $session->addFlashMessage("success", "The request has been validated");
    }

    public function refuseRequestTeacher(): void
    {
        $requestManager = new RequestTeacher();
        $id_request = $this->request->get("id");
        $requestManager = $requestManager->setId($id_request);
        $requestManager->setStatut(-1);
        $requestManager->save();
        header('Location: /teachers/allRequests');
        $session = Session::getInstance();
        $session->addFlashMessage("success", "The request has been refused");
    }

}