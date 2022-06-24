<?php

namespace App\Controller;

use App\Core\View;
use App\Controller\BaseController;

class Main extends BaseController{

    public function home()
    {

    // Permet de savoir si le fichier existe
    //$filename ='conf.inc.php';      
    $filename ='conf.php';  
    
    if(file_exists($filename)){
        echo "Le fichier $filename existe.";
        echo "Welcome";
    }else {
        echo "Le fichier $filename n'existe pas.";
        $view = new View("installeur", "back");
        $view->assign("firstname", "Ricardo");
        $view->assign("lastname", "Hernandez");
        
    }
    }


    public function front()
    {
        $view = new View("contact", "front");
    }

    public function install()
    {
        $filename ='conf.php'; 
        // double securité verifier si le fichier conf existe, si il existe il faut rediriger vers l'index.php
        if(file_exists($filename)){ 
            echo "Vous avez déjà installer ";
        }else{
            // Pour eviter de se faire hacker
            $myfile = fopen("conf.php", "w");
            if (!empty($_GET)) {

                //echo("Super");
                //var_dump($_GET);

                foreach ($_GET as $value) {
                    //echo($value);
                    $txt = 'define("MAIL_SENDER_NAME",'.$value.')';

                    fwrite($myfile,$txt);
                    fwrite($myfile, "\n");
                }

                #echo($myfile);
                echo("********************************");
                echo("<br>");
                echo("Bravo L'instalation est faite");

            }
        }
    }

}