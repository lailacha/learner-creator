<?php

namespace App\Core;

class Verificator
{

    public static function checkForm($config, $data): array
    {
        $captcha = new Recaptcha();
        $errors = [];

        if( count($config["inputs"]) != count($data)){
            die("Tentative de hack");
        }

        foreach ($config["inputs"] as $name=>$input)
        {
            if(!isset($data[$name])){
                $errors[]="Il manque le champ :".$name;
            }

            if(!empty($input["required"]) && empty($data[$name]) ){
                $errors[]=$name ." ne peut pas être vide";
            }

            if($input["type"]=="email" &&  !self::checkEmail($data[$name])) {
                $errors[]=$input["error"];
            }

            if($input["type"]=="file" &&  !self::checkFile($data[$name])) {
                $errors[]= "Votre fichier n'est pas au bon format (jpeg, jpg, svg, png) et doit être > 1000.";
            }

            if($input["type"]=="password" &&  !self::checkPwd($data[$name]) && empty($input["confirm"])) {
                $errors[]=$input["error"];
            }

            if($input["type"]=="captcha" && !$captcha->checkRecaptcha($_POST['g-recaptcha-response'])) {
                $errors[]=$input["error"];
            }

            if( !empty($input["confirm"]) && $data[$name]!=$data[$input["confirm"]]  ){
                $errors[]=$input["error"];
            }

        }


        return $errors;
    }


    public static function checkEmail($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function checkFile($file)
    {
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        echo $fileName;


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
    }

    public static function checkPwd($pwd): bool
    {
        return strlen($pwd)>=8
            && preg_match("/[0-9]/",$pwd, $result )
            && preg_match("/[A-Z]/",$pwd, $result );
    }
}