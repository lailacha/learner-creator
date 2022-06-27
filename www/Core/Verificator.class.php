<?php

namespace App\Core;

use App\Core\Session;

class Verificator
{

    public static function checkForm($config, HttpRequest $request): array
    {
        $data = $request->getData();
        $captcha = new Recaptcha();
        $errors = [];

        
        //var_dump($config["inputs"]);
        //var_dump($data);

        // ajout du cas où il n'y a pas d'erreur 
        if(is_null($data)){
            $errors = [];
            return $errors;
        }

        if(count($config["inputs"]) !== count($data)){
                $errors[] = "Le nombre d'inputs ne correspond pas au nombre d'inputs envoyés";
//             echo var_dump(array_keys($config["inputs"]));
//             echo "<br>";
//                echo var_dump(array_keys($data));
        }

        foreach ($config["inputs"] as $name=>$input)
        {

            if(!empty($input["required"]) && empty($data[$name]) ){
                $errors[]=$name ." ne peut pas être vide";
            }

            if(!empty($input["required"]) && $input["type"] === "file" && $data[$name]["error"] === 4){
                $errors[]=$name ." ne peut pas être vide";
            }

            if($input["type"] === "email" &&  !self::checkEmail($data[$name])) {
                $errors[]=$input["error"];
            }

            if($input["type"] === "csrf_token" &&  !self::checkCrsf($data[$name])) {
                $errors[]=$input["error"];
            }

            if($input["type"]=="file" && !empty($input[$name]) && !self::checkFile($data[$name])) {
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

    
    public static function checkCrsf($csrf): bool
    {
        /* we check csrf token here */
        
        $token = filter_input($csrf, 'token');

        if (!$token || $token !== $_SESSION['csrf_token’’']) {
            // return 405 http status code
            //header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
            return false;
            //exit;
        } else {
            return true;
        }
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