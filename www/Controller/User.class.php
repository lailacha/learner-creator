<?php

namespace App\Controller;

use App\Core\Helpers;
use App\Core\ReceivePassword;
use App\Core\Session;
use App\Core\User as UserClean;
use App\Core\Verificator;
use App\Core\View;
use App\Core\Mail;
use App\Core\FormBuilder;
use App\Core\Recaptcha;
use App\Model\User as UserModel;
use App\Model\ReceivePassword as ReceivePasswordModel;

class User {

    public function login()
    {
        $user = new UserModel();

        if (!empty($_POST)) {

            $user->setEmail(htmlspecialchars($_POST["email"]));
            $user->setPassword(htmlspecialchars($_POST["password"]));
            $user->login(["email" => $_POST['email']]);

        }


        $view = new View("login");
        $form = FormBuilder::render($user->getLoginForm());
        $view->assign("form", $form);
    }

    public function recoverPassword()
    {
        $user = new UserModel();
        $receivePassword = new ReceivePasswordModel();

        if (!empty($_POST)) {
            print_r($user->getBy("email", $_POST['email']));
            ReceivePassword::GenerateToken();
//            print_r($_POST);
        }

        $view = new View("forgotPassword");
        $form = FormBuilder::render($receivePassword->getForgetPswdForm());
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

            if ($verification) {
//                $user = $user->getBy("id", 33);
//
//                $user->setEmail("y.sssvhvhvhvsjjjjsss@gmail.com");
//
//                //$user->setPassword("Test1234");
//                //$user->setLastname("SKrzypCZK   ");
//                //$user->setFirstname("  YveS");
//                //$user->generateToken();
//
//                $user->save();

                //$this->sendRegisterMail($user);
                $session->set("error",$verification[0] );
                $user->setFirstname(htmlspecialchars($_POST["firstname"]));
                $user->setLastname(htmlspecialchars($_POST["lastname"]));
                $user->setEmail(htmlspecialchars($_POST["email"]));
                $user->setPassword(htmlspecialchars($_POST["password"]));

                $user->generateToken((Helpers::createToken()));

                $user->save();

            }

            $session->set("success", "Your registration is OK!");
        }

        $view = new View("Register");
        $form = FormBuilder::render($user->getRegisterForm());
        $view->assign("form", $form);
    }


    /**
     * @param UserModel $user
     *
     *  Send a email to user to verify his account.
     */
        public function sendRegisterMail(UserModel $user)
        {
            $html = '<a href="http://localhost:84/verifyAccount?token='.$user->getToken().'&mail='.$user->getEmail().'"><h2>Click here to validate your account!</h2></a>';

            $confirmMail = new Mail();
            $confirmMail->setSubject("Last step to validate your account...");
            $confirmMail->setContent($html);
            $confirmMail->setApiKey(MAILJET_API_KEY);
            $confirmMail->setReceiver($user->getEmail());
            $confirmMail->setReceiverName($user->getFirstname(). " ".$user->getLastname());
            $confirmMail->sendMail();


    /**
     * Called when user click on validation email.
     * Check if the account is correct, and set the status to verified.
     *
     */
        public function verifyAccount()
        {
            $userManager = new UserModel();
           $user = $userManager->getOneByMany(["token" =>  $_GET["token"], "email" => $_GET["mail"]]);

           if(!$user){
               // TODO ADD flash message when available
                echo "Il n'y a pas d'utilisateur";
                return;
           }else{
               $user->setStatus(1);
               $user->save();

               echo "Your account is validated !";
           }


        }


}











