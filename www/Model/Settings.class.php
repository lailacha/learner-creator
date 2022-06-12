<?php


namespace App\Model;


use App\Core\FormBuilder;
use App\Core\Sql;

class Settings  extends Sql
{
    protected $id;
    protected $value;


    public function __construct()
    {
        parent::__construct();
        $this->table  = DBPREFIXE."appearance_settings";
    }

    public function getId()
    {
        return $this->id;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getSettingsForm()
    {
        $mainColor = $this->getBy('id', 'main_color');
        return [
            "config" => [
                "method" => "POST",
                "action" => "/save/settings",
                "enctype" => "multipart/form-data",
                "class" => "form ",
                "submit" => "Save settings"
            ],
            "inputs" => [
                "main_color" => [
                    "type" => "color",
                    "value" => $mainColor->getValue(),
                    "required" => true,
                    "error" => "Please enter a valid color",
                ],
                "sidebar_color" => [
                    "type" => "color",
                    "value" => $this->getBy('id', 'sidebar_color')->getValue(),
                    "required" => true,
                    "error" => "Please enter a valid color",
                ],
          ]];

    }
}