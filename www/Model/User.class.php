<?php

namespace App\Model;

use App\Core\Session;
use App\Core\Sql;
use App\Model\File as FileModel;
use App\Model\User as UserModel;

class User extends Sql
{
    protected $id = null;
    protected $firstname = null;
    protected $lastname = null;
    protected $email;
    protected $avatar;
    protected $status = 0;
    protected $password;
    protected $token = null;

   
    public function __construct()
    {
        //echo "constructeur du Model User";
       $this->getPDO();
    }

    /**
     * @return null
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param null $firstname
     */
    public function setFirstname(?string $firstname): void
    {
        $this->firstname = ucwords(strtolower(trim($firstname)));
    }

    /**
     * @return null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param null $lastname
     */
    public function setLastname(?string $lastname): void
    {
        $this->lastname = strtoupper(trim($lastname));
    }

    /**
     * @return mixed
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail(string $email): void
    {
        $this->email = strtolower(trim($email));
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
     * @return mixed
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function fullName(): ?string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function avatar()
    {
        $fileManager = new FileModel();
        if ($this->getAvatar() !== null) {

            return $fileManager->getBy('id', $this->getAvatar())->getPath();
        }

        return null;

    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @return null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param null
     */
    public function generateToken(): void
    {
        $bytes = random_bytes(128);
        $this->token = substr(str_shuffle(bin2hex($bytes)), 0, 255);
    }


    public function save(): void
    {
        //Pré traitement par exemple
        //echo "pre traitement";
       
        parent::save();
    }


    public static function getUserConnected() {
        $session = new Session();
        if($session->get("user") != null) {
            $userManager = new UserModel();
            $userConnected =  $userManager->setId($session->get("user")["id"]);
            return $userConnected;
        }
        return false;
    }


    public function getEditProfileForm()
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "/save/profile",
                "id" => "formRegister",
                "enctype" => "multipart/form-data",
                "class" => "form editProfilForm",
                "submit" => "Edit"
            ],
            "inputs" => [
                "avatar" => [
                    "type" => "file",
                    "id" => "avatar",
                    "class" => "file",
                    "required" => false,
                    "error" => " Votre image doit être de la bonne extension",
                ],
                "firstname" => [
                    "placeholder" => "Enter your name",
                    "type" => "text",
                    "id" => "firstnameRegister",
                    "value" => $this->getFirstname(),
                    "class" => "formRegister",
                    "required" => true,
                    "min" => 2,
                    "max" => 25,
                    "error" => " Votre prénom doit faire entre 2 et 25 caractères",
                ],
                "lastname" => [
                    "type" => "text",
                    "placeholder" => "Votre nom de famille ...",
                    "id" => "testRegister",
                    "required" => true,
                    "value" => $this->getLastname(),
                    "class" => "formRegister",
                    "error" => " Votre nom doit faire entre 2 et 100 caractères",
                ],
            ],
        ];
    }

    public function getRegisterForm(): array
    {
        
        return [
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "formRegister",
                "enctype" => "multipart/form-data",
                "class" => "form register",
                "submit" => "Sign in"
            ],
            "inputs" => [
            "firstname" => [
                "placeholder" => "Enter your name",
                "type" => "text",
                "id" => "firstnameRegister",
                "class" => "formRegister",
                "required" => true,
                "min" => 2,
                "max" => 25,
                "error" => " Votre prénom doit faire entre 2 et 25 caractères",
            ],    
            "lastname" => [
                "type" => "text",
                "placeholder" => "Votre nom de famille ...",
                "id" => "testRegister",
                "required" => true,
                "value" => "testRegister",
                "class" => "formRegister",
                "error" => " Votre nom doit faire entre 2 et 100 caractères",
            ],    
            "email" => [
                    "placeholder" => "Votre email ...",
                    "type" => "email",
                    "id" => "emailRegister",
                    "class" => "formRegister",
                    "required" => true,
                    "error" => "Email incorrect",
                    "unicity" => true,
                    "errorUnicity" => "Un compte existe déjà avec cet email"
                ],
              "password" => [
                  "placeholder" => "Votre mot de passe ...",
                    "type" => "password",
                    "id" => "pwdRegister",
                    "class" => "formRegister",
                    "required" => true,
                    "error" => "Votre mot de passe doit faire au min 8 caratères avec une majuscule et un chiffre"
                ],
                "passwordConfirm" => [
                    "placeholder" => "Confirmation ...",
                    "type" => "password",
                    "id" => "pwdConfirmRegister",
                    "class" => "formRegister",
                    "required" => true,
                    "error" => "Votre confirmation de mot de passe ne correspond pas",
                    "confirm" => "password"
                ],
               
                "g-recaptcha-response" => [
                    "type" => "captcha",
                    "error" => "Veuillez valider le captcha si vous êtes un humain :)",
              ],
////To test types of inputs
//                "ville" => [
//                    "type" => "checkbox",
//                    "checked" => "checked",
//                    "id" => "testRegister",
//                    "value" => "testRegister",
//                    "class" => "formRegister",
//                    "error" => "",
//                ],
//                "pays" => [
//                    "type" => "radio",
//                    "id" => "tesPays",
//                    "class" => "formRegister",
//                    "options" => [
//                        "test" => ["value" => "France",
//                            "label" => "france"],
//                        "test2" => ["label" => "Maroc",
//                            "value" => "maroc",
//                            "checked" => "checked"]],
//                    "error" => " Votre nom doit faire entre 2 et 100 caractères",
//                ],
//                "description" => [
//                    "type" => "textarea",
//                    "id" => "description",
//                    "class" => "formRegister",
//                    "rows" => 2,
//                    "cols" => 10,
//                    "content" => "Je suis une description",
//                    "error" => " Votre description doit faire entre 2 et 100 caractères",
//                ],
//                "région" => [
//                    "type" => "select",
//                    "id" => "jjj",
//                    "class" => "formRegister",
//                    "options" => [
//                        "test" => ["libelle" => "Normandie",
//                            "value" => "test"],
//                        "test2" => [ "libelle" => "Nord Pas De Calais","value" => "test2",  "selected" => "selected"]],
//                    "error" => " Veuillez selectionner une région",
//                ],
//
//            "photo" => [
//                "type" => "file",
//                "id" => "testFile",
//                "class" => "file",
//                "error" => " Votre photo doit être de la bonne extension",
//
//            ]
        ],
        ];
    }


    public function getLoginForm(): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "formLogin",
                "class" => "formLogin",
                "submit" => "Se connecter"
            ],
            "inputs" => [
                "email" => [
                    "placeholder" => "Votre email ...",
                    "type" => "email",
                    "id" => "emailRegister",
                    "class" => "formRegister",
                    "required" => true,
                ],
                "password" => [
                    "placeholder" => "Votre mot de passe ...",
                    "type" => "password",
                    "id" => "pwdRegister",
                    "class" => "formRegister",
                    "required" => true,
                ]
            ]
        ];
    }
    public function getForgetPswdForm(): array
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "formLogin",
                "class" => "formLogin",
                "submit" => "Se connecter"
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



}