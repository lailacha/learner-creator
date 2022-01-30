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
        }

        $html .= " <input type='submit' value='".($config["config"]["submit"] ?? '')."'>";
        $html .= "</form>";
         return $html;
    }

    private function renderCheckbox(string $name, array $checkbox): string
    {
         $data = "<label for='".($name ?? "")."'>".$name."</label>";
         $data .= " <input type='checkbox' class='".($checkbox["class"] ?? '')."' ".($checkbox["checked"] ?? '')." id='".($checkbox["id"] ?? '')."' name='".($name ?? '')."'  value='".($checkbox["value"] ?? '')."'>";
         $data .= " <input type='hidden' name='".($name ?? '')."'  value='0'>";

        return $data;

    }

    private function renderRadio(string $name, array $radio): string
    {
        $data ="";
        foreach ($radio["options"] as $option){
            if(isset($option["label"]))
            {
            $data .= "<label for='".($name ?? "")."'>".$option["label"]."</label>";
            }
            $data .= " <input type='radio' ".($option["checked"] ?? '')." class='".($option["class"] ?? '')."' id='".($option["id"] ?? '')."' name='".($name ?? "")."'>";
        }
        return $data;
    }

    private function renderSelect(string $name, array $select): string
    {
        $data = "<select class='".($select["class"] ?? '')."' name='".($name ?? '')."' id='".($option["id"] ?? '')."' >";
        foreach ($select["options"] as $option){
            $data .= " <option class='".($option["class"] ?? '')."' ".($option["selected"] ?? '')." value='".($option["value"] ?? '')."' >";
            $data .= $option["libelle"];
            $data .= "";
            $data .= " </option>";

        }
        $data .= "</select>";
        return $data;
    }

    private function renderTextarea(string $name, array $textarea): string
    {
        $data ="";
            $data .= " <textarea class='".($textarea["class"] ?? '')."' id='".($textarea["id"] ?? '')."' cols='".($textarea["cols"] ?? '')."' placeholder='".($textarea["content"] ?? '')."' rows='".($textarea["rows"] ?? '')."' name='".($name ?? "")."'>";
            $data .= "</textarea>";
        return $data;
    }


    private function renderInput(string $name, array $input): string
    {

        $data = " <input type='".($input["type"] ?? 'text')."'  class='".($input["class"] ?? '')."'  id='".($input["id"] ?? '')."' placeholder='".($input["placeholder"] ?? '')."' name='".($name ?? "")."'/>";
        return $data;
    }

}