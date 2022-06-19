<?php

namespace App\Controller;

use App\Core\View;
use App\Controller\BaseController;

class Main extends BaseController{

    public function home()
    {

    // Permet de savoir si le fichier existe
    $filename ='./conf.inc.php';

    
    if(!is_dir($filename)){
        echo "Le fichier $filename existe.";
        $view = new View("installeur", "back");
        $view->assign("firstname", "Ricardo");
        $view->assign("lastname", "Hernandez");
        
        echo "Welcome";
    }else {
        echo "Le fichier $filename n'existe pas.";
    }
    }


    public function front()
    {
        $view = new View("contact", "back");
    }

    public function install()
    {
        // double securité verifier si le fichier conf existe, si il existe il faut rediriger vers l'index.php
        // Pour eviter de se faire hacker
        $myfile = fopen("conf.php", "w");
        if (!empty($_GET)) {

            echo("Super");
            var_dump($_GET);

            foreach ($_GET as $value) {
                echo($value);
                $txt = 'define("MAIL_SENDER_NAME",'.$value.')';

                fwrite($myfile,$txt);
                fwrite($myfile, "\n");
            }

            #echo($myfile);
            echo("********************************");
            echo("\n");
            echo("Bravo L'instalation est faite");

        }
    }

}