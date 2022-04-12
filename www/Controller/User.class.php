<?php

namespace App\Controller;
use App\Core\Helpers;
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
        $user = new UserModel();

        if(!empty($_POST)) {

            $user->setEmail(htmlspecialchars($_POST["email"]));
            $user->setPassword(htmlspecialchars($_POST["password"]));
            $user->login(["email" => $_POST['email']]);

        }


        $view = new View("login");
        $form = FormBuilder::render($user->getLoginForm());
        $view->assign("form", $form);
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
                $user->setFirstname(htmlspecialchars($_POST["firstname"]));
                $user->setLastname(htmlspecialchars($_POST["lastname"]));
                $user->setEmail(htmlspecialchars($_POST["email"]));
                $user->setPassword(htmlspecialchars($_POST["password"]));
                
                $user->generateToken((Helpers::createToken()));

                $user->save();
                
            }
            
            $session->set("success","Your registration is OK!" );
        }

        $view = new View("Register");
        $form = FormBuilder::render($user->getRegisterForm());
        $view->assign("form", $form);
    }




}











