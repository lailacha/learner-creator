<?php

namespace App\Core;

use App\Core\Recaptcha;

class FormBuilder
{

    public static function render(array $config): string
    {
        $html = "<form 
				method='" . ($config["config"]["method"] ?? "POST") . "' 
				id='" . ($config["config"]["id"] ?? "") . "' 
				class='" . ($config["config"]["class"] ?? "") . "'
				enctype='" . ($config["config"]["enctype"] ?? "") . "'
				action='" . ($config["config"]["action"] ?? "") . "'>";

        foreach ($config["inputs"] as $name=>$input){
                $input["type"] === "checkbox" ?   $html .= self::renderCheckbox($name,$input) : "";
                $input["type"] === "radio" ?   $html .= self::renderRadio($name,$input) : "";
                $input["type"] === "textarea" ?   $html .= self::renderTextarea($name,$input) : "";
                $input["type"] === "select" ?   $html .= self::renderSelect($name,$input) : "";
                $input["type"] === "file" || $input["type"] === "text" || $input["type"] === "password"|| $input["type"] === "email" ?   $html .= self::renderInput($name,$input) : "";
                $input["type"] === "captcha" ?  $html .= (new Recaptcha())->renderRecaptcha() : "";
                $input["type"] === "hidden" ?  $html .= self::renderHidden($name,$input) : "";
        }

        $html .= " <input type='submit' value='".($config["config"]["submit"] ?? '')."'>";
        $html .= "</form>";
         return $html;
    }

    private static function renderCheckbox(string $name, array $checkbox): string
    {
        if(isset($data["label"]))
        {
            $data .= "<label for='".($name ?? "")."'>".ucfirst($name)."</label>";
        }
        $data .= " <input type='checkbox' class='".($checkbox["class"] ?? '')."' ".($checkbox["checked"] ?? '')." id='".($checkbox["id"] ?? '')."' name='".($name ?? '')."'  value='".($checkbox["value"] ?? '')."'>";
         $data .= " <input type='hidden' name='".($name ?? '')."'  value='0'>";

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

    //render input type hidden
    private static function renderHidden(string $name, array $input): string
    {
        $data = " <input type='hidden' id='".($input["id"] ?? '')."' name='".($name ?? '')."'  value='".($input["value"] ?? '')."'>";
        return $data;
    }


    private static function renderSelect(string $name, array $select): string
    {
        //array of options example
    /*    "category" => [
            "type" => "select",
            "id" => "jjj",
            "class" => "formRegister",
            "options" => [
                "test" => ["libelle" => "Math", "value" => "1"],
                "test2" => [ "libelle" => "French ", "value" => "2",  "selected" => "selected"]],

    options => [
 data:[[   "id" => "",
    "name" => "",
    "category,],

     [   "id" => "",
    "name" => "",
    "category,]

    ]]
    , property: "name",
    value: id,
    class: "formRegister",
    selected: 1,

        ]*/

        $value = $select["options"]["value"] ?? "";
        $property = $select["options"]["property"] ?? "";
        $selected = $select["options"]["selected"] ?? "";

        $data = "<select name={$name}  class='".($select["class"] ?? '')."' id='".($select["id"] ?? '')."'>";
        foreach($select["options"]["data"] as $option){
            $data .= " <option  ". ($selected === $option[$value]  ? "selected" :  '')." value='".($option[$value] ?? '')."' >";
            $data .= $option[$property];
            $data .= " </option>";

        }
        return $data."</select>";



//
//        $selected = $select["selected"] ?? "";
//        $data = "<select class='".($select["class"] ?? '')."' name='".($name ?? '')."' id='".($option["id"] ?? '')."' >";
//        foreach ($select["options"] as $option){
//            $data .= " <option  ". ($selected === $name  ? "selected" :  '')." value='".($option["value"] ?? '')."' >";
//            $data .= $option["libelle"];
//            $data .= "";
//            $data .= " </option>";
//
//        }
//        $data .= "</select>";
//        return $data;
    }

    private static function renderSelectMultiple(string $name, array $select): string
    {
        $selected = $select["selected"] ?? "";
        $data = "<select class='".($select["class"] ?? '')."' name='".($name ?? '')."' id='".($option["id"] ?? '')."' multiple>";
        foreach ($select["options"] as $option){
            $data .= " <option  ". ($selected === $name  ? "selected" :  '')." value='".($option["value"] ?? '')."' >";
            $data .= $option["libelle"];
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
            $data .= " <textarea class='".($textarea["class"] ?? '')."' id='".($textarea["id"] ?? '')."' cols='".($textarea["cols"] ?? '')."' placeholder='".($textarea["placeholder"] ?? '')."' rows='".($textarea["rows"] ?? '')."' name='".($name ?? "")."'>";
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



}