<?php

namespace App\Core;

use App\Core\Recaptcha;

class FormBuilder
{

    public static function render(array $config): string
        {

        //$_SESSION["csrf_token"] = md5(uniqid(mt_rand(), true));
        
        $html = "<form 
				method='" . ($config["config"]["method"] ?? "POST") . "' 
				id='" . ($config["config"]["id"] ?? "") . "' 
				class='" . ($config["config"]["class"] ?? "") . "'
				enctype='" . ($config["config"]["enctype"] ?? "") . "'
				action='" . ($config["config"]["action"] ?? "") . "'>";

        foreach ($config["inputs"] as $name=>$input){
            $input["type"] === "checkbox" ?   $html .= self::renderCheckbox($name,$input) : "";
            $input["type"] === "color" ?   $html .= self::renderColor($name,$input) : "";
            $input["type"] === "radio" ?   $html .= self::renderRadio($name,$input) : "";
            $input["type"] === "textarea" ?   $html .= self::renderTextarea($name,$input) : "";
            $input["type"] === "select" ?   $html .= self::renderSelect($name,$input) : "";
            $input["type"] === "file" || $input["type"] === "text" || $input["type"] === "password"|| $input["type"] === "submit"|| $input["type"] === "email" || $input["type"] === "number" ? $html .= self::renderInput($name,$input) : "";
            $input["type"] === "captcha" ?  $html .= (new Recaptcha())->renderRecaptcha() : "";
            $input["type"] === "custom" ?  $html .= self::renderCustomHtml($input) : "";
            $input["type"] === "hidden" ?  $html .= self::renderHidden($name,$input) : "";
        }

       // $html .= " <input type='hidden' name='csrf_token' value='".$_SESSION["csrf_token"]."'>";
        $html .= " <input type='submit' value='".($config["config"]["submit"] ?? '')."'>";
        $html .= "</form>";

         return $html;
    }

    private static function renderCheckbox(string $name, array $checkbox): string
    {
        $data = "";
        if(isset($checkbox["label"]))
        {
            $data .= "<label for='".($name ?? "")."'>".$checkbox["label"];
        }
        $data .= " <input type='hidden' name='".($name ?? '')."'  value='false'>";
        $data .= " <input type='checkbox' class='".($checkbox["class"] ?? '')."' ".($checkbox["checked"] ?? '')." id='".($checkbox["id"] ?? '')."' name='".($name ?? '')."'  value='".($checkbox["value"] ?? '')."'>";
        if(isset($checkbox["label"]))
        {
            $data .= "</label>";
        }
        return $data;

    }

    private static function renderRadio(string $name, array $radio): string
    {
        $data ="";
        foreach ($radio["options"] as $option){
            if(isset($option["label"]))
            {
            $data .= "<label for='".($name ?? "")."'>".ucfirst($name)."</label>";
            }   
            $data .= " <input type='radio' ".($option["checked"] ?? '')." class='".($option["class"] ?? '')."' id='".($option["id"] ?? '')."' name='".($name ?? "")."'>";
        }
        return $data;
    }

    private static function renderHidden(string $name, array $input): string
    {
        $data = " <input type='hidden' id='".($input["id"] ?? '')."' name='".($name ?? '')."'  value='".($input["value"] ?? '')."'>";
        return $data;
    }


    private static function renderSelect(string $name, array $select): string
    {
        $property = $select["options"]["property"] ?? "";
        $value = $select["options"]["value"] ?? "";
        $selected = $select["options"]["selected"] ?? "";

        $data = "";

        if(isset($select["label"]))
        {
            $data = "<label for='".($name ?? "")."'>".$select["label"]."</label>";
        }
        
        $data .= "<select class='".($select["class"] ?? '')."' name='".($name ?? '')."' id='".($option["id"] ?? '')."' >";
        foreach ($select["options"]["data"] as $option){
            $data .= " <option class='".($option["class"] ?? '')."' ".( $option[$value] === $selected? 'selected' : '')." value='".($option[$value] ?? '')."' >";
            $data .= $option[$property];
            $data .= "";
            $data .= " </option>";
        }
        $data .= "</select>";
        return $data;
    }

    private static function renderTextarea(string $name, array $textarea): string
    {
            $data= "";
            if(isset($data["label"]))
            {
                $data .= "<label for='".($name ?? "")."'>".ucfirst($name)."</label>";
            }
  
        $data = "<label for='".($name ?? "")."'>".ucfirst($name)."</label>";
        $data .= " <textarea class='".($textarea["class"] ?? '')."' id='".($textarea["id"] ?? '')."' cols='".($textarea["cols"] ?? '')."' placeholder='".($textarea["content"] ?? '')."' rows='".($textarea["rows"] ?? '')."' name='".($name ?? "")."'>";
        $data .= $textarea["value"] ?? "";
        $data .= "</textarea>";
        return $data;
    }


    private static function renderInput(string $name, array $input): string
    {
        $data = "<label for='".($name ?? "")."'>".ucfirst($name)."</label>";
        $data .= " <input value='".($input["value"] ?? '')."'  type='".($input["type"] ?? 'text')."'  class='".($input["class"] ?? '')."'  id='".($input["id"] ?? '')."' placeholder='".($input["placeholder"] ?? '')."' ".($input["disabled"] ?? "")." name='".($name ?? "")."'./>";
        return $data;
    }


    public static function renderCustomHtml(array $input): string
    {
        return $input["html"] ?? "";
    }

    private static function renderColor(int|string $name, mixed $input)
    {
        $data = "<label for='".($name ?? "")."'>".ucfirst($name)."</label>";
        $data .= " <input value='".($input["value"] ?? '')."'  type='color'  class='".($input["class"] ?? '')."'  id='".($input["id"] ?? '')."' placeholder='".($input["placeholder"] ?? '')."' ".($input["disabled"] ?? "")." name='".($name ?? "")."'./>";
        return $data;
    }


}