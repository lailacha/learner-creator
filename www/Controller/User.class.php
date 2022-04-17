<?php

namespace App\Controller;

use App\Core\Helpers;
use App\Core\QueryBuilder;
use App\Core\ReceivePassword;
use App\Core\Session;
use App\Core\User as UserClean;
use App\Core\Verificator;
use App\Core\View;
use App\Core\FormBuilder;
use App\Core\Recaptcha;
use App\Model\User as UserModel;
use App\Model\ReceivePassword as ReceivePasswordModel;
use DateTime;

class User
{
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


    public function logout()
    {
        echo "Se déconnecter";
    }


    public function register()
    {
        $user = new UserModel();
        $session = new Session();

        if (!empty($_POST)) {


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

    public function recoverPassword()
    {
        $user = new UserModel();
        $receivePasswordManager = new ReceivePasswordModel();
        $receivePass = new ReceivePassword();

        if (!empty($_POST)) {
            echo "<pre>";

            $user = $user->getBy("email", $_POST['email']);

            $idUser = $user->getId();

            $receivePasswordManager->setToken(Helpers::createToken());
            $receivePasswordManager->setIdUser($idUser);
            $receivePasswordManager->setEmail($user->getEmail());
            $receivePasswordManager->save();
            $receivePass->sendPasswordResetEmail($receivePasswordManager);

        }

        $view = new View("forgotPassword");
        $form = FormBuilder::render($receivePasswordManager->getForgetPswdForm());
        $view->assign("form", $form);

    }

    public function changePassword()
    {


        $user = new UserModel();
        $receivePasswordManager = new ReceivePasswordModel();

        $token = $_GET['token'] ?? null;
        $email = $_GET['email'] ?? null;
        $idUser = $_GET['id'] ?? null;


        $query = new QueryBuilder();

        $query->from('receive_password')
            ->where('iduser = :iduser', 'token = :token')
            ->setParams([
                "iduser" => $idUser,
                "token" => $token
            ]);

        $result = $query->fetch();

        $count = (clone $query)->count();

        $dateFinal = new DateTime();
        $dateDebut = new DateTime($result['createdAt']);
        $dateDifference = $dateFinal->diff($dateDebut);
        $heureDifference = $dateDifference->days * 24 + (int)$dateDifference->format('%H');
        $heureDifference = (int)$heureDifference;



        if ($count === 1 && $result['status'] == 0 && $heureDifference < 48) {
            $view = new View("changePassword");

            if (!empty($_POST)) {
                $data = array_merge($_POST, $_FILES);
                // Plus tard faut utiliser Class verificator pour verifier le password
                $receivePasswordManager = $receivePasswordManager->getBy('id', $result['id']);
                $receivePasswordManager->setStatus(1);
                $receivePasswordManager->save();
                $user = $user->getBy('id', $idUser);
                $user->setPassword($_POST['password']);
                $user->save();

            }
            else{

                $form = FormBuilder::render($receivePasswordManager->getChangePswdForm());
                $view->assign("form", $form);

            }



        } else {

            die("Veuillez refaire votre demande");

        }


    }

}











