<?php

namespace App\Controller;

use App\Core\FormBuilder;
use App\Core\View;
use App\Model\File;
use App\Model\RequestTeacher;
use App\Model\Role;
use App\Model\User as UserModel;
use App\Controller\BaseController;

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

    // public function editUser(): void
    // {

    //     $user = new UserModel();
    //     $id_user = $this->request->get("id");
    //     $user = $user->getBy('id', $id_user);


    //     if ($user) {

    //     $action = $_POST['_method'] ?? null;
    //     $idUser = $_POST['id_user'] ?? null;


    //     if ($action === "delete" && !empty($idUser)){
    //         $user->deleteUser($idUser);
    //         header('Location: /users');
    //     }
    //     elseif ($action === "edit" && !empty($idUser)){
    //         header('location: /editUser?id='.$idUser);
    //     }
    //     $view = new View("users", "back");
    //     $view->assign("listUsers", $listUsers);

    // }
    // }


    public function editUser(): void
    {
        $idUser = $this->request->get('user_id');
        $user = new UserModel();
        $user = $user->getBy('id',$idUser);
        if ($user){
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
        $requestManager->setStatut(1);
        $requestManager->save();
        header('Location: /teachers/requestInProgress');
    }
    public function refuseRequestTeacher(): void
    {
        $requestManager = new RequestTeacher();
        $id_request = $this->request->get("id");
        $requestManager = $requestManager->setId($id_request);
        $requestManager->setStatut(-1);
        $requestManager->save();
        header('Location: /teachers/requestInProgress');
    }

}