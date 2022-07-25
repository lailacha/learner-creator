<?php

namespace App\Controller;

use App\Core\View;
use App\Controller\BaseController;
use App\Controller\User as ControllerUser;
use App\Core\Session;
use App\Model\User as UserModel;
use App\Model\LessonProgress;
use App\Model\Lesson;
use App\Model\Learner;
use App\Model\Course;
use App\Model\User;





class Main extends BaseController
{



    public function dashboard(){
            $lessonProgressManager = new LessonProgress();
            $lastLessonProgress = $lessonProgressManager->getLastLessons();
            $view = new View("dashboardLearner");

            if(count($lastLessonProgress) > 0){
                $view->assign("courses", $lastLessonProgress);

            }
    
            $courseManager = new Course();
            $learner = new Learner();
            $user = User::getUserConnected()->getId();


            $checkPref = $learner->checkPrefUser($user);
                if($checkPref == 1){
                $categoryPref = $learner->getAllCategories($user);
                $suggestions = $courseManager->getAll("category", $categoryPref);
                $view->assign("suggestions", $suggestions);
                }
            
    }

    public function home()
    {
        $session = new Session();
        $user = new UserModel();

        // Permet de savoir si le fichier existe
        //$filename ='conf.inc.php';
        $filename = 'conf.php';

        if (file_exists($filename)) {
            $view = new View("home", "home");
            $session->addFlashMessage("success", "Le fichier s'est bien installé.");
        } else {
            $view = new View("installeur", "back");
            $session->addFlashMessage("success", "Le fichier $filename n'existe pas.");

        }
    }


    public function contact()
    {
        $view = new View("contact", "front");
    }

    public function install()
    {

        $user = new UserModel();

        $filename = 'conf.php';
        // double securité verifier si le fichier conf existe, si il existe il faut rediriger vers l'index.php
        if (file_exists($filename)) {
            echo "Vous avez déjà installer ";
        } else {
            // Pour eviter de se faire hacker
            if (!empty($_GET)) {
                $myfile = fopen("conf.inc.php", "w");
                fwrite($myfile, "\n");


                //echo("Super");
                //var_dump($_GET);

                $txt = "<?php";
                fwrite($myfile, $txt);
                fwrite($myfile, "\n");


                $txt = 'define("CAPTCHA_SECRET_KEY","' . $_GET["CAPTCHA_SECRET_KEY"] . '");';
                fwrite($myfile, $txt);
                fwrite($myfile, "\n");

                $txt = 'define("MAIL_SENDER_NAME","' . $_GET["MAIL_SENDER_NAME"] . '");';
                fwrite($myfile, $txt);
                fwrite($myfile, "\n");
                $txt = 'define("MAILJET_API_KEY","' . $_GET["MAILJET_API_KEY"] . '");';
                fwrite($myfile, $txt);
                fwrite($myfile, "\n");
                $txt = 'define("MAIL_SENDER","' . $_GET["MAIL_SENDER"] . '");';
                fwrite($myfile, $txt);
                fwrite($myfile, "\n");
                $txt = 'define("DBNAME","' . $_GET["DBNAME"] . '");';
                fwrite($myfile, $txt);
                fwrite($myfile, "\n");
                $txt = 'define("DBDRIVER","' . $_GET["DBDRIVER"] . '");';
                fwrite($myfile, $txt);
                fwrite($myfile, "\n");
                $txt = 'define("DBUSER","' . $_GET["DBUSER"] . '");';
                fwrite($myfile, $txt);
                fwrite($myfile, "\n");
                $txt = 'define("DBPWD","' . $_GET["DBPWD"] . '");';
                fwrite($myfile, $txt);
                fwrite($myfile, "\n");
                $txt = 'define("DBHOST","' . $_GET["DBHOST"] . '");';
                fwrite($myfile, $txt);
                fwrite($myfile, "\n");
                $txt = 'define("DBPORT","' . $_GET["DBPORT"] . '");';
                fwrite($myfile, $txt);
                fwrite($myfile, "\n");
                $txt = 'define("DBPREFIXE","' . $_GET["DBPREFIXE"] . '");';
                fwrite($myfile, $txt);
                fwrite($myfile, "\n");
                $txt = 'define("MB",' . $_GET["MB"] . ');';
                fwrite($myfile, $txt);
                fwrite($myfile, "\n");

                $myfile = fopen("conf.php", "w");
                $txt = "fichier temoins pour certifier de l'installation";
                fwrite($myfile, $txt);
                #echo($myfile);
                echo("********************************");
                echo("<br>");
                echo("Bravo L'instalation est faite");
                //$user->initdb();
            }
        }
    }

}