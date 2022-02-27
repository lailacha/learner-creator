<?php


class FileUpload
{
    public function upload($file, string $directory){

        if (move_uploaded_file($file["tmp_name"],  "./images/cover-".$file["name"])) {

        } else {
            die("Il y a un problème avec le fichier");
        }

    }

    public function checkFile($file){


        //Créer des catégories de fichiers

        // recuperer le fichier de la requete et le transformer en entité FIle puis, check puis upload

        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $extensions = ["jpeg", "png", "svg", "jpg"];
        if(!in_array($fileExtension, $extensions))
        {
            return false;
        }

        if($fileSize > (5*MB))
        {
            echo $fileSize;
            return false;
        }
        return true;



        //check if file exist

        // ajouter à une categori de fichier une restriction de taille


        //upload
        if (move_uploaded_file($file["tmp_name"],  "./images/cover-".$file["name"])) {

        } else {
            die("Il y a un problème avec le fichier");
        }

    }
}