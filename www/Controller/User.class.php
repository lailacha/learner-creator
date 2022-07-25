<?php

namespace App\Controller;

use App\Core\Helpers;
use App\Core\QueryBuilder;
use App\Core\ReceivePassword;
use App\Core\Session;
use App\Model\Course;
use App\Model\Learner;
use App\Model\Settings;
use App\Model\CourseCategory;
use App\Core\Verificator;
use App\Core\View;
use App\Core\Mail;
use App\Core\FormBuilder;
use App\Model\User as UserModel;
use App\Model\ReceivePassword as ReceivePasswordModel;
use App\Service\File;
use DateTime;
use PDO;
use App\Core\Sql;


class User extends BaseController
{

    public function login()
    {

        $user = new UserModel();
        $session = Session::getInstance();
        $verification = Verificator::checkForm($user->getLoginForm(), $this->request);

        if (!$verification) {
            if (!empty($_POST) && $user->login($_POST['email'], $_POST['password'])) {
                $role = $user->getRole($session->get('user')["id"]);
                $session->set('role', $role);

                // if ($_POST["csrf_token"] !== $_SESSION['csrf_token']) 
                //     echo var_dump($_SESSION['csrf_token']);
                //     echo var_dump($_POST['csrf_token']);
                //     die("CSRF token invalid");
                //     $session->addFlashMessage("error", "csrf not valid! ");
                //     header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');


                if ($user) {

                    $user->setEmail(htmlspecialchars($_POST["email"]));
                    $user->setPassword(htmlspecialchars($_POST["password"]));
                    $user->login($_POST['email'], $_POST['password']);

                    $session->addFlashMessage("success", "Bienvenue");
                    $session->addFlashMessage("success", "Vous êtes maintenant connecté");
                    header('Location: /edit/profile');

                }

                $session->addFlashMessage("error", "Identifiants incorrects");


                $user->setEmail(htmlspecialchars($_POST["email"]));
                $user->setPassword(htmlspecialchars($_POST["password"]));

                $session->addFlashMessage("success", "Bienvenue");

            }

        } else {
            $session->addFlashMessage("error", $verification[0]);
        }

        $view = new View("login", "home");
        $form = FormBuilder::render($user->getLoginForm());
        $view->assign("form", $form);


    }


    public function logout()
    {

        session_destroy();
        header('Location: /');
    }


    public function register()
    {


        $user = new UserModel();
        $session = Session::getInstance();
        if (!empty($_POST)) {

            $verification = Verificator::checkForm($user->getRegisterForm(), $this->request);

            if (!$verification) {
                // if ($_POST["csrf_token"] !== $_SESSION['csrf_token']) {
                //     echo var_dump($_SESSION['csrf_token']);
                //     echo var_dump($_POST['csrf_token']);
                //     die("CSRF token invalid");
                //     return;
                //     $session->addFlashMessage("error", "csrf not valid! ");
                //     header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
                // }

                $isRegistred = $user->getBy("email", $_POST["email"]);
                if (!$isRegistred) {

                    $user->setFirstname(htmlspecialchars($_POST["firstname"]));
                    $user->setLastname(htmlspecialchars($_POST["lastname"]));
                    $user->setEmail(htmlspecialchars($_POST["email"]));
                    $user->setPassword(htmlspecialchars($_POST["password"]));

                    $user->generateToken((Helpers::createToken()));
                    $user->setAvatar(194);
                    $user->save();
                    $this->sendRegisterMail($user);
                    $this->session->destroy();
                    $this->route->redirect("/login");

                    $session->addFlashMessage("success", "Your registration is OK!");
                } else {
                    $session->addFlashMessage("error", "Vous etes déjà inscrit");
                }

            } else {
                $session->addFlashMessage("error", $verification[0]);
            }
        }
        // echo var_dump($_SESSION['csrf_token']);

        $view = new View("register", "home");
        $form = FormBuilder::render($user->getRegisterForm());
        $view->assign("form", $form);

    }


    public function recoverPassword()
    {
        $user = new UserModel();
        $receivePasswordManager = new ReceivePasswordModel();
        $receivePass = new ReceivePassword();
        $session = Session::getInstance();

        if (!empty($_POST)) {

            $user = $user->getBy("email", $_POST['email']);

            if ($user) {
                $idUser = $user->getId();

                $receivePasswordManager->setToken(Helpers::createToken());
                $receivePasswordManager->setIdUser($idUser);
                $receivePasswordManager->setEmail($user->getEmail());
                $receivePasswordManager->save();
                $receivePass->sendPasswordResetEmail($receivePasswordManager);
            }

            $session->addFlashMessage("success", "Un mail de réinitialisation de mot de passe vous a été envoyé.");

        }

        $view = new View("forgotPassword", "home");
        $form = FormBuilder::render($user->getForgetPswdForm());
        $view->assign("form", $form);

    }


    public function changePassword()
    {


        // FAUT AJOUTER DES MESSAGES FLUSH SVP
        $user = new UserModel();
        $receivePasswordManager = new ReceivePasswordModel();

        $token = $_GET['token'] ?? null;
        $email = $_GET['mail'] ?? null;
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

            $view = new View("changePassword", "home");
            $form = FormBuilder::render($user->getChangePswdForm());
            $view->assign("form", $form);

            if (!empty($_POST)) {
                $this->request->setData($_POST);
                $verification = Verificator::checkForm($user->getChangePswdForm(), $this->request);
                if (!$verification) {
                    $receivePasswordManager = $receivePasswordManager->getBy('id', $result['id']);
                    $receivePasswordManager->setStatus(1);
                    $receivePasswordManager->save();
                    $user = $user->getBy('id', $idUser);
                    $user->setPassword(htmlspecialchars($_POST['password']));
                    $user->save();
                    $this->session->addFlashMessage("success", "Votre mot de passe a été modifié");
                    $this->route->redirect("/login");
                } else {
                    $this->session->addFlashMessage("error", $verification[0]);
                }


            }


        } else {

            die("Veuillez refaire votre demande");

        }
    }

    // test

    /**
     * @param UserModel $user
     *
     *  Send a email to user to verify his account.
     */
    public function sendRegisterMail(UserModel $user)
    {
        $html = '<a href="http://learner-creator.online/verifyAccount?token=' . $user->getToken() . '&email=' . $user->getEmail() . '"><h2>Click here to validate your account!</h2></a>';

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
        $user = $userManager->getOneByMany(["token" => $this->request->get("token"), "email" => $this->request->get("email")]);


        if (!$user) {
            // TODO ADD flash message when available
            $this->session->addFlashMessage("error", "Il n'y a pas d'utilisateur");

            return;
        } else {
            $user->setStatus(1);
            $user->save();
            $this->session->addFlashMessage("success", " Your account is validated !");
            // FAUT ACTIVER LES MESSAGES FLUSH DANS TEMPLATE FRONT
            header('Location: /login');


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

        $learner = new Learner();


        $formCat = FormBuilder::render($learner->getCategoryPrefForm());
        $view->assign("formCat", $formCat);
        $form = FormBuilder::render($user->getEditProfileForm());
        $view->assign("form", $form);
        $view->assign("user", $user);

        $categoriesNumb = $learner->getAllCategories($user->getId());
        $view->assign("categoriesNumb", $categoriesNumb);

        $categories = new CourseCategory();
        $view->assign("categories", $categories);


    }

    public function delete(): void
    {
        $user = new UserModel();
        $id_user = $this->request->get("user_id") ?? null;
        if ($id_user) {
            $user->deleteUser($id_user);
            header('Location: /users');
        }
    }

    public function saveCatPref()
    {


        $learner = new Learner();
        $user = UserModel::getUserConnected()->getId();
        $course = $learner->setCategory($this->request->get("category"));
        $course = $learner->getCategory();

        $learner->setUser($user);

        $catVerif = $learner->catVerif($user, $course);

        if ($catVerif === 0) {

            $learner->save();
            header('Location: /edit/profile');
        } else {
            echo $this->session->addFlashMessage("success", "Vous avez déjà préféré cette catégorie");
            header('Location: /edit/profile');

        }

    }

    public function deleteCatPref()
    {
        $sessoion = Session::getInstance();
        $learner = new Learner();
        $user = UserModel::getUserConnected()->getId();
        $course = $learner->setCategory($this->request->get("category"));
        $course = $learner->getCategory();
        $learner->setUser($user);
        echo $learner->deleteCatPref($user, $course);
        header('Location: /edit/profile');
        $session->addFlashMessage("success", "Vous avez supprimé votre préférence pour la catégorie");
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
            if (isset($_POST['modifyPassword']) && !empty($_POST['modifyPassword']) && $_POST['modifyPassword'] === $_POST['confirmModifyPassword']) {
                $user->setPassword($_POST['modifyPassword']);
            }

            {
                $user->setFirstname($this->request->get('firstname'));
                $user->setLastname($this->request->get('lastname'));
            }
            if (!empty($this->request->get("avatar")) && $this->request->get("avatar") !== $user->getAvatar() && isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {

                try {
                    $file = new File($_FILES["avatar"]);
                    $file = $file->upload("avatar", 3);
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

        } else {
            $this->session->addFlashMessage("error", $errors[0]);
            $this->route->redirect("/edit/profile");

        }

    }

    public function verifyPassword()
    {

        $password = $_POST['password'];
        $user = UserModel::getUserConnected();
        if (password_verify($password, $user->getPassword())) {
            echo 1;
        } else {
            echo 0;
        }

    }
}











