<?php

namespace App\Controller;

use App\Core\Session;
use App\Core\User as UserClean;
use App\Core\Verificator;
use App\Core\View;
use App\Core\FormBuilder;
use App\Core\Recaptcha;
use App\Model\User as UserModel;

class User {

    public function login()
    {
        $view = new View("login");
        $view->assign("title", "Ceci est le titre de la page login");
    }

    public function logout()
    {
        echo "Se déconnecter";
    }


    public function register()
    {
        $user = new UserModel();
        $session = new Session();

        if(!empty($_POST)) {

            $data = array_merge($_POST, $_FILES);
            $verification = Verificator::checkForm($user->getRegisterForm(), $data);
            if($verification)
            {
//                $user = $user->setId(33);
//
//                $user->setEmail("y.sssvhvhvhvsjjjjsss@gmail.com");
//
//                //$user->setPassword("Test1234");
//                //$user->setLastname("SKrzypCZK   ");
//                //$user->setFirstname("  YveS");
//                //$user->generateToken();
//
//                $user->save();
                $session->set("error",$verification[0] );
            }

            $session->set("success","Your registration is OK!" );
        }

        $view = new View("Register");
        $form = FormBuilder::render($user->getRegisterForm());
        $view->assign("form", $form);
    }




}











