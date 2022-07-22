<?php

namespace App\Model;


use App\Model\User;
use App\Core\QueryBuilder;
use App\Core\Sql;

class RequestTeacher extends Sql
{
    protected $id = null;
    protected $user_id;
    protected $motivation;
    protected $theme;
    protected $cv;
    protected $diplome;
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
    public function getCv()
    {
        return $this->cv;
    }

    /**
     * @param mixed $cv
     */
    public function setCv($cv): void
    {
        $this->cv = $cv;
    }

    /**
     * @return mixed
     */
    public function getDiplome()
    {
        return $this->diplome;
    }

    /**
     * @param mixed $diplome
     */
    public function setDiplome($diplome): void
    {
        $this->diplome = $diplome;
    }


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

    public function getAllRequest(): array
    {
        $query = new QueryBuilder();
        return $query->from('request_teachar')
            ->fetchAllByClass(__CLASS__);
    }
    public function getAllRequestInProgress(): array
    {
        $query = new QueryBuilder();
        return $query->from('request_teachar')
            ->where('statut = 0')
            ->fetchAllByClass(__CLASS__);
    }

    public function getUser()
    {
        $query = new QueryBuilder();
        return $query->from('user')
            ->where('id = ' . $this->user_id)
            ->fetchByClass(User::class);
    }

    public function getCreateRequestForm()
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "",
                "class" => "form",
                "enctype" => "multipart/form-data",
                "submit" => "Valider"
            ],
            "inputs" => [
                "motivation" => [
                    "placeholder" => "Vos motivations",
                    "value" => "",
                    "type" => "textarea",
                    "id" => "motivationInput",
                    "class" => " editable",
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
                "cv" => [
                    "type" => "file",
                    "id" => "cv",
                    "class" => "cv",
                    "required" => false,
                    "error" => " Votre fichier doit être de la bonne extension",
                ],
                "diplome" => [
                    "type" => "text",
                    "id" => "diplome",
                    "required" => true,
                    "class" => "diplome",
                    "placeholder" => "Votre dernier diplome",
                ],
                "user_id" => [
                    "type" => "hidden",
                    "value" => User::getUserConnected()->getId(),
                ],

            ]
        ];
    }
}