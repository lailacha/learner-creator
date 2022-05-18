<?php

namespace App\Model;


use App\Core\QueryBuilder;
use App\Core\Sql;

class RequestTeacher extends Sql
{
    protected $id = null;
    protected $user_id;
    protected $motivation;
    protected $theme;
    protected $iban;
    protected $statut = 0;

    /**
     * @return null
     */


    public function __construct()
    {
        parent::__construct();
        parent::setTable(DBPREFIXE . "request_teachar");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }
    /**
     * @return mixed
     */



    /**
     * @return mixed
     */
    public function getMotivation()
    {
        return $this->motivation;
    }

    /**
     * @param mixed $motivation
     */
    public function setMotivation($motivation): void
    {
        $this->motivation = $motivation;
    }

    /**
     * @return mixed
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param mixed $theme
     */
    public function setTheme($theme): void
    {
        $this->theme = $theme;
    }


    /**
     * @return mixed
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * @param mixed $iban
     */
    public function setIban($iban): void
    {
        $this->iban = $iban;
    }

    /**
     * @return null
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @param null $statut
     */
    public function setStatut($statut): void
    {
        $this->statut = $statut;
    }

    public function save(): void
    {

        parent::save();
    }

    public function getAllRequestInProgress(): array
    {
        $query = new QueryBuilder();
        return $query->from('request_teachar')->where('statut = 0')->fetchAll();
    }

    public function getCreateRequestForm()
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "",
                "class" => "",
                "submit" => "Valider"
            ],
            "inputs" => [
                "motivation" => [
                    "placeholder" => "Vos motivations",
                    "value" => "",
                    "type" => "textarea",
                    "id" => "motivationInput",
                    "class" => "formRegister",
                    "required" => true,
                ],
                "theme" => [
                    "placeholder" => "theme ",
                    "value" => "",
                    "type" => "text",
                    "id" => "themeInput",
                    "class" => "formRegister",
                    "required" => true,
                ],
//                "theme" => [
//                    "type" => "select",
//                    "options" => [
//                        "data" => [
//                            "Back-end",
//                            "Front-end",
//                            "Infra",
//                            "Docker"
//                        ],
//                        "property" => "name",
//                        "value" => "id",
//                        "selected" => 1
//
////                        ["value" => "Back-end", "libelle" => "Back-end"],
////                        ["value" => "Front-end", "libelle" => "Front-end"],
////                        ["value" => "Infra", "libelle" => "Infra"],
////                        ["value" => "Docker", "libelle" => "Docker"],
//                    ],
//                    "id" => "selectRegister",
//                    "required" => true,
//                    "class" => "formRegister",
//                ],


                "iban" => [
                    "type" => "text",
                    "id" => "ibanRegister",
                    "required" => true,
                    "class" => "formRegister",
                    "placeholder" => "Votre IBAN",

                ],

            ]
        ];
    }
}