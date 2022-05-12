<?php

namespace App\Controller;

use DateTime;
use App\Core\Mail;
use App\Core\View;
use App\Core\Helpers;
use App\Core\Session;
use App\Service\File;
use App\Core\Recaptcha;
use App\Core\FormBuilder;
use App\Core\Verificator;
use App\Core\QueryBuilder;
use App\Core\ReceivePassword;
use App\Core\User as UserClean;
use App\Model\User as UserModel;
use App\Model\ReceivePassword as ReceivePasswordModel;


class User extends BaseController
{

    public function login()
    {
        $user = new UserModel();
        if (!empty($_POST) && $user->login($_POST['email'], $_POST['password'])) {
            $role = $user->getRole($this->session->set('user')["id"]);
            $this->session->set('role', $role);

        if (!empty($_POST)) {

            $user->setEmail(htmlspecialchars($_POST["email"]));
            $user->setPassword(htmlspecialchars($_POST["password"]));
            $user->login(["email" => $_POST['email']], ["password" => $_POST['password']]);
        }
        $view = new View("login", "home");

        $form = FormBuilder::render($user->getLoginForm());
        $view->assign("form", $form);
    }
}


    public function logout()
    {

        session_destroy();
        echo "Se déconnecter";
    }


    public function register()
    {

        $user = new UserModel();
        $session = new Session();

        if (!empty($_POST)) {


            $verification = Verificator::checkForm($user->getRegisterForm(), $this->request);

            if (!$verification) {

                $user->setFirstname(htmlspecialchars($_POST["firstname"]));
                $user->setLastname(htmlspecialchars($_POST["lastname"]));
                $user->setEmail(htmlspecialchars($_POST["email"]));
                $user->setPassword(htmlspecialchars($_POST["password"]));

                $user->generateToken((Helpers::createToken()));
                $this->sendRegisterMail($user);

                $user->save();
                $session->addFlashMessage("success", "Your registration is OK!");
                return;

            }
            $session->addFlashMessage("error", $verification[0]);
        }

        $view = new View("Register","home");
        $form = FormBuilder::render($user->getRegisterForm());
        $view->assign("form", $form);
    }

    public function recoverPassword(): void
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

    /**
     * @param UserModel $user
     *
     *  Send a email to user to verify his account.
     */
    public function sendRegisterMail(UserModel $user)
    {
        $html = '<a href="http://localhost:84/verifyAccount?token=' . $user->getToken() . '&mail=' . $user->getEmail() . '"><h2>Click here to validate your account!</h2></a>';

        $confirmMail = new Mail();
        $confirmMail->setSubject("Last step to validate your account...");
        $confirmMail->setContent($html);
        $confirmMail->setApiKey(MAILJET_API_KEY);
        $confirmMail->setReceiver($user->getEmail());
        $confirmMail->setReceiverName($user->getFirstname() . " " . $user->getLastname());
        $confirmMail->sendMail();

    }

    public function changePassword(): void
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


    public function show()
    {
        $userManager = new UserModel();
        $user = $userManager->setId($this->request->get("user_id"));

        $courseManger = new Course();
        $courses = $courseManger->getAllBy('user', $user->getId());

        $view = new View("showProfile", "back");
        $view->assign('user', $user);
        $view->assign('courses', $courses);

    }


    public function edit()
    {
        $view = new View("editProfile");
        $user = UserModel::getUserConnected();

        $form = FormBuilder::render($user->getEditProfileForm());
        $view->assign("form", $form);
        $view->assign("user", $user);

    }

    public function saveProfile()
    {
        $user = UserModel::getUserConnected();
        $errors = Verificator::checkForm($user->getEditProfileForm(), $this->request);
        if(!$errors)
        {

            if(!empty($this->request->get('firstname')) && $this->request->get('firstname') !== $user->getFirstname())
            {
                $user->setFirstname($this->request->get('firstname'));
            }

            if(!empty($this->request->get('lastname')) && $this->request->get('lastname') !== $user->getLastname())
            {
                $user->setLastname($this->request->get('lastname'));
            }

            {
                $user->setFirstname($this->request->get('firstname'));
                $user->setLastname($this->request->get('lastname'));
            }
            if(!empty($this->request->get("avatar")) && $this->request->get("avatar") !== $user->getAvatar() && isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {

                try {
                    $file = new File($_FILES["avatar"]);
                    $file = $file->upload( "avatar", 3);
                } catch (\Exception $e) {
                    $this->session->addFlashMessage("error", $e->getMessage());
                    $this->route->redirect("/edit/profile");
                    return;
                }
                $user->setAvatar($file->getLastInsertId());
            }

            $user->save();
            $this->session->addFlashMessage("success", "Votre profile a bien été modifié");
            $this->route->redirect("/edit/profile");

        }
        else{
            $this->session->addFlashMessage("error",$errors[0]);
            $this->route->redirect("/edit/profile");

        }
    }

}











