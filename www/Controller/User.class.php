<?php

namespace App\Controller;

use App\Core\Helpers;
use App\Core\ReceivePassword;
use App\Core\Session;
use App\Model\Course;
use App\Core\Verificator;
use App\Core\View;
use App\Core\Mail;
use App\Core\FormBuilder;
use App\Model\User as UserModel;
use App\Model\ReceivePassword as ReceivePasswordModel;
use App\Service\File;


class User extends BaseController
{

    public function login()
    {
        $user = new UserModel();
        $session = Session::getInstance();
        
        if (!empty($_POST) && $user->login($_POST['email'], $_POST['password'])) {
            $role = $user->getRole($session->get('user')["id"]);
            $session->set('role', $role);
            
            header('Location: /edit/profile');
        }
        $view = new View("login", "home");
        
        $form = FormBuilder::render($user->getLoginForm());
        $view->assign("form", $form);
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
                $session->set("error", $verification[0]);
                $user->setFirstname(htmlspecialchars($_POST["firstname"]));
                $user->setLastname(htmlspecialchars($_POST["lastname"]));
                $user->setEmail(htmlspecialchars($_POST["email"]));
                $user->setPassword(htmlspecialchars($_POST["password"]));

                $user->generateToken((Helpers::createToken()));
                
                $user->save();
                $session->addFlashMessage("success", "Your registration is OK!");
               

            }
            $session->addFlashMessage("error", $verification[0]);
        }

        $view = new View("Register","home");
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
        echo "aze";
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

    /**
     * Called when user click on validation email.
     * Check if the account is correct, and set the status to verified.
     *
     */
    public function verifyAccount()
    {
        $userManager = new UserModel();
        $user = $userManager->getOneByMany(["token" => $this->request->get("token"), "email" => ["mail"]]);

        if (!$user) {
            // TODO ADD flash message when available
            echo "Il n'y a pas d'utilisateur";
            return;
        } else {
            $user->setStatus(1);
            $user->save();

            echo "Your account is validated !";
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

    public function delete(): void
    {
        $user = new UserModel();
        $id_user = $this->request->get("id") ?? null;
        if ($id_user) {
            $user->deleteUser($id_user);
            header('Location: /users');
        }
    }

    public function saveProfile()
    {
        $user = UserModel::getUserConnected();
        $errors = Verificator::checkForm($user->getEditProfileForm(), $this->request);
        if (!$errors) {

            if (!empty($this->request->get('firstname')) && $this->request->get('firstname') !== $user->getFirstname()) {
                $user->setFirstname($this->request->get('firstname'));
            }

            if (!empty($this->request->get('lastname')) && $this->request->get('lastname') !== $user->getLastname()) {
                $user->setLastname($this->request->get('lastname'));
            }

            {
                $user->setFirstname($this->request->get('firstname'));
                $user->setLastname($this->request->get('lastname'));
            }
            if (!empty($this->request->get("avatar")) && $this->request->get("avatar") !== $user->getAvatar()) {
                if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {

                    try {
                        $file = new File($_FILES["avatar"]);
                        $file = $file->upload("avatar", 3);
                    } catch (\Exception $e) {
                        $this->session->addFlashMessage("error", $e->getMessage());
                        return;
                    }
                    $user->setAvatar($file->getLastInsertId());
                }

            }

            $user->save();
            $this->session->addFlashMessage("success", "Votre profile a bien été modifié");
            $this->route->redirect("/edit/profile");

        } else {
            $this->session->addFlashMessage("error", $errors[0]);
        }
    }
}











