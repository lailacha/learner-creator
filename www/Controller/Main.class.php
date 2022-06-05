<?php

namespace App\Controller;

use App\Core\View;
use App\Controller\BaseController;

class Main extends BaseController{

    public function home()
    {
        
        
            // Get current directory
    echo getcwd() . "<br>";

    // Change directory
    chdir("../");

    // Get current directory
    echo getcwd();

    $dir = getcwd();

    // Permet de savoir si le fichier existe
    $filename = $dir.'/conf.inc.php';
        if (file_exists($filename)) {
            echo "Le fichier $filename existe.";
        } else {
            echo "Le fichier $filename n'existe pas.";
        }

    /* Permet d'afficher le contenu d'un dossier */
    /* if (is_dir($dir)){
        if ($dh = opendir($dir)) {
          while (($file = readdir($dh)) !== false){
            echo "filename:" . $file . "<br>";
          }
          closedir($dh);
        }
    } */

        echo "Welcome";
    }


    public function front()
    {
        $view = new View("contact", "back");
    }

}