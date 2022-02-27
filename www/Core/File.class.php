<?php


namespace App\Core;


class File
{

    public function __construct(){

    }

    public function upload($file, string $directory = "assets"){

        $filepath = $file['tmp_name'];
        $fileSize = filesize($filepath);
        $fileName = $file['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));


        if ($fileSize === 0) {
            die("The file is empty.");
        }

        if($fileSize > (5*MB)) {
            echo "large";

            die("The file is too large");
            }

        $extensions = ["jpeg", "png", "svg", "jpg"];
        if(!in_array($fileExtension, $extensions))
        {
            echo $fileExtension;
            die("The file do not use good extension");
        }
echo $filepath;
        if (move_uploaded_file($file["tmp_name"],  "./images/".$directory."/".$fileName)) {

        } else {
            die("Il y a un problème avec le fichier");
        }

    }
}