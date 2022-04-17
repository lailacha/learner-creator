<?php

namespace App\Model;

use App\Core\Sql;

class ReceivePassword extends Sql
{
    protected $id = null;
    protected $idUser;
    private $email;
    protected $status = 0;
    protected $token = null;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }


    public function __construct()
    {
        parent::__construct();
        parent::setTable(DBPREFIXE . "receive_password");
    }

    public function save(): void
    {

        parent::save();
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return null
     */
    public function getToken()
    {
        return $this->token;
    }


    public function setToken(string $token): void
    {
        $this->token = $token;
    }


    public function getForgetPswdForm(): array
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
                "email" => [
                    "placeholder" => "Votre email ...",
                    "type" => "email",
                    "id" => "emailRegister",
                    "class" => "formRegister",
                    "required" => true,
                ],

            ]
        ];
    }

    public function getChangePswdForm() : array
    {
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "id" => "",
                "class" => "",
                "submit" => "Valider"
            ],
            "inputs"=>[
                "password" => [
                    "placeholder" => "Votre mot de passe ...",
                    "type" => "password",
                    "id" => "newPassword",
                    "class" => "formRegister",
                    "required" => true,
                    "error" => "Votre mot de passe doit faire au min 8 caratères avec une majuscule et un chiffre"
                ],
                "passwordConfirm" => [
                    "placeholder" => "Confirmation ...",
                    "type" => "password",
                    "id" => "confirmPassword",
                    "class" => "formRegister",
                    "required" => true,
                    "error" => "Votre confirmation de mot de passe ne correspond pas",
                    "confirm" => "password"
                ]
            ]
        ];
    }

}