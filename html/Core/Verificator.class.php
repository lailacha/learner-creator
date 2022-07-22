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

        $inputsToVerify =  array_diff_key($config["inputs"], array_flip(["custom", "disabled"]));

        // ajout du cas où il n'y a pas d'erreur 
        if(is_null($data)){
            $errors = [];
            return $errors;
        }

        if(count($config["inputs"]) !== count($inputsToVerify)){
                $errors[] = "Le nombre d'inputs ne correspond pas au nombre d'inputs envoyés";
        }

        foreach ($config["inputs"] as $name=>$input)
        {

            if(!empty($input["max"]) && strlen($data[$name]) > $input["max"]) {
                $errors[]=$name ." est trop grand. Le maximum de caractères est ".$input["max"]."";
            }

            if(!empty($input["min"]) && strlen($data[$name]) < $input["min"]) {
                $errors[]=$name ." est trop petitx. Le minimum de caractères est ".$input["min"]."";
            }

            if(!empty($input["required"]) && empty($data[$name]) ){
                $errors[]=$name ." ne peut pas être vide";
            }

            if(!empty($input["required"]) && $input["type"] === "file" && $data[$name]["error"] === 4){
                $errors[]=$name ." ne peut pas être vide";
            }

            if($input["type"] === "email" &&  !self::checkEmail($data[$name])) {
                $errors[]=$input["error"];
            }

            if($input["type"]=="file" && !empty($input[$name]) && !self::checkFile($data[$name])) {
                $errors[]= "Votre fichier n'est pas au bon format (jpeg, jpg, svg, png) et doit être > 1000.";
            }

            if ($input["type"] == "password" && !self::checkPwd($data[$name]) && empty($input["confirm"]) && $input["required"]) {
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

        $extensions = ["jpeg", "png", "svg", "jpg"];
        if(!in_array($fileExtension, $extensions))
        {
            return false;
        }

        if(($fileSize > (5*MB))  || $fileSize == 0)
        {
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