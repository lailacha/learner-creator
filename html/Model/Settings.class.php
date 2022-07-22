<?php


namespace App\Model;


use App\Core\FormBuilder;
use App\Core\Sql;
use App\Model\File as FileModel;


class Settings  extends Sql
{
    protected $id;
    protected $value;


    public function __construct()
    {
        parent::__construct();
        $this->table  = DBPREFIXE."appearance_settings";
    }

    public static function getInstance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
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


    public function getLogo()
    {
        return $this->getBy('id', 'logo')->getValue();
    }


    public function getLogoFile()
    {
        $fileManager = new FileModel();
        $file = $fileManager->getBy('id', $this->getLogo());

        if($file)
        {
            return $file->getPath();
        }
        else
        {
            return null;
        }
        
    }



    public function getGeneralSettingsForm()
    {

        return [
            "config" => [
                "method" => "POST",
                "action" => "/save/generalSettings",
                "enctype" => "multipart/form-data",
                "class" => "form settings-form ",
                "submit" => "Save settings"
            ],
            "inputs" => [
                "site_name" => [
                    "type" => "text",
                    "value" => $this->getBy('id', 'site_name')->getValue(),
                    "required" => true,
                    "error" => "Le nom du site est obligatoire"
                ],
                "site_description" => [
                    "type" => "text",
                    "value" => $this->getBy('id', 'site_description')->getValue(),
                    "required" => true,
                    "error" => "La description du site est obligatoire"
                ],
                "allow_comment" => [
                    "label" => "Autoriser les commentaires",
                    "type" => "checkbox",
                    "value" => "allow",
                    "checked" => $this->getBy('id', 'allow_comment')->getValue() == "true" ? "checked" : "",
                ],
                "default_role" => [
                    "type" => "select",
                    "label" => "Rôle par défaut",
                    "options" => [
                        "data" =>
                          [ [
                               "id" => 1,
                               "name" => "User"
                           ],
                           [
                               "id" => 3,
                               "name" => "Admin"
                           ]],
                        "property" => "name",
                        "value" => "id",
                    ]]
            ],

        ];

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
                "logo" => [
                    "type" => "file",
                    "id" => "avatar",
                    "class" => "file",
                    "required" => false,
                    "error" => " Votre image doit être de la bonne extension",
                ],
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
                "primary_color" => [
                    "type" => "color",
                    "value" => $this->getBy('id', 'primary_color')->getValue(),
                    "required" => true,
                    "error" => "Please enter a valid color",
                ],
                "big_title_size" => [
                    "type" => "text",
                    "value" => $this->getBy('id', 'big_title_size')->getValue(),
                    "required" => true,
                    "error" => "Please enter a valide value",
                ],
                "main_font" => [
                    "type" => "select",
                    "label" => "Main police",
                    "options" => [
                        "data" =>
                          [ [
                               "name" => "Montserrat",
                           ],
                           [
                               "name" => "cursive",
                           ],
                           [
                            "name" => "Rubyk",
                             ],
                             ["name" => "Lato"]

                        ],
                        "property" => "name",
                        "value" => "name",
                        "selected" => $this->getBy('id', 'main_font')->getValue()
                    ]]
                ,
          ]];

    }
}