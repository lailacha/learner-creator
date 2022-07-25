<?php

namespace App\Model;

use App\Core\Mail;
use App\Core\QueryBuilder;
use App\Core\Session;
use App\Core\Sql;
use App\Model\File as FileModel;
use App\Model\User as userManager;
use App\Model\User as UserModel;
use App\Model\CourseCategory as CourseCategoryModel;

class User extends Sql 
{
    protected $id = null;
    protected $firstname = null;
    protected $lastname = null;
    protected $createdAt = null;
    protected $email = null;
    protected $avatar;
    protected $role_id = 1;
    protected $status = 0;
    protected $password;
    protected $token = null;

    public function __construct()
    {
        //echo "constructeur du Model User";
        parent::__construct();
    }

    /**
     * @return null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getRoleId(): int
    {
        return $this->role_id;
    }

    /**
     * @param int $role_id
     */
    public function setRoleId(int $role_id): void
    {
        $this->role_id = $role_id;
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


    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
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


    public function isAdmin()
    {
        $this->getRoleId() === 3 ;
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

    public function update(Course $course): void
    {
        $confirmMail = new Mail();
        $confirmMail->setSubject("A new course of your preference has been added".$course->getName());
        $confirmMail->setContent("<h1> A new course of your preference has been added</h1>");
        $confirmMail->setApiKey(MAILJET_API_KEY);
        $confirmMail->setReceiver($this->getEmail());
        $confirmMail->setReceiverName($this->getFirstname() . " " . $this->getLastname());
        $confirmMail->sendMail();
    
    }


    public function save(): void
    {   
        parent::save();
    }

    public function login($email, $password): bool
    {
        $query = new QueryBuilder();
        $user = $query->from('user')
            ->where('email = :email')
            ->setParam('email', $email)
            ->fetch();


        $session = new Session();
        if ($user && password_verify($password, $user["password"])) {
            $session->set("user", $user);
            $session->addFlashMessage("success", "Vous êtes connecté");
            return true;
        }

        $session->addFlashMessage("error", "identifiants incorrects");
        return false;

    }

    
    public function getAllUsers(): array
    {
        $users = [];
        $query = new QueryBuilder();
        $results = $query->from('user')
            ->fetchAllByClass(__CLASS__);

        return $results;
    }

    public function getRole(int $id = null): string
    {
        $query = new QueryBuilder();
        $user_id = $this->id ?? $id;
        return $query->from('user')
            ->innerJoin('role', DBPREFIXE . 'user.role_id =' . DBPREFIXE . 'role.id')
            ->where(DBPREFIXE . 'user.id = :id')
            ->setParam('id', $user_id)
            ->fetch("name");
    }

    function deleteUser(int $id)
    {
        $sql = "DELETE FROM " . DBPREFIXE . "user WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }



    public static function getUserConnected()
    {
        $session = new Session();
        if ($session->get("user") != null) {
            $userManager = new UserModel();
            $userConnected = $userManager->setId($session->get("user")["id"]);
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
                "password" => [
                    "type" => "password",
                    "placeholder" => "Saisissez votre mot de passe",
                    "id" => "passwordEditProfile",
                    "required" => true,
                    "value" => "",
                    "class" => "formRegister",
                    "error" => "Votre mot de passe doit faire au min 8 caratères avec une majuscule et un chiffre"
                ],
                "Modifier le mot de passe" => [
                    "type" => "checkbox",
                    "label" => "Modifier votre mot de passe",
                    "name" => "modifyPassword",
                    "id" => "checkPassword",
                    "required" => false,
                    "class" => "formRegister ",
                    "error" => "Votre mot de passe doit faire au min 8 caratères avec une majuscule et un chiffre"
                ],
                "modifyPassword" => [
                    "type" => "password",
                    "placeholder" => "Saisissez votre mot de passe",
                    "id" => "modifyPassword",
                    "required" => false,
                    "value" => "",
                    "class" => "formRegister modifyPassword",
                    "error" => "Votre mot de passe doit faire au min 8 caratères avec une majuscule et un chiffre"
                ],
                "confirmModifyPassword" => [
                    "type" => "password",
                    "placeholder" => "Saisissez votre mot de passe",
                    "id" => "validPassword",
                    "required" => false,
                    "value" => "",
                    "class" => "formRegister modifyPassword",
                    "error" => "Votre mot de passe doit faire au min 8 caratères avec une majuscule et un chiffre"
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
                "id" => "formLogin",
                "class" => "formLogin",
                "enctype" => "multipart/form-data",
//                "class" => "form register formLogin",
                "submit" => "Sign in"
            ],
            "inputs" => [
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
                "firstname" => [
                    "placeholder" => "Votre prénom ...",
                    "type" => "text",
                    "id" => "firstnameRegister",
                    "class" => "formRegister",
                    "min" => 2,
                    "max" => 25,
                    "error" => " Votre prénom doit faire entre 2 et 25 caractères",
                ],

                "lastname" => [
                    "type" => "text",
                    "placeholder" => "Votre nom de famille ...",
                    "id" => "testRegister",
                    "min" => 2,
                    "max" => 100,
                    "class" => "formRegister",
                    "error" => " Votre nom doit faire entre 2 et 100 caractères",
                ],
                "g-recaptcha-response" => [
                    "type" => "captcha",
                    "error" => "Veuillez valider le captcha si vous êtes un humain :)",
                ],
            ],
        ];
    }

    public function getEditUserForm(): array
    {
        $roleManager = new Role();

        return [
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "formEditUser",
                "enctype" => "multipart/form-data",
                "class" => "form edit",
                "submit" => "Modifier"
            ],
            "inputs" => [
                "firstname" => [
                    "placeholder" => $this->getFirstname(),
                    "value" => $this->getFirstname(),
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
                    "placeholder" => $this->getLastname(),
                    "value" => $this->getLastname(),
                    "id" => "testRegister",
                    "required" => true,
                    "class" => "formRegister",
                    "error" => " Votre nom doit faire entre 2 et 100 caractères",
                ],
                "email" => [
                    "placeholder" => $this->getEmail(),
                    "value" => $this->getEmail(),
                    "type" => "email",
                    "id" => "emailRegister",
                    "class" => "formRegister",
                    "required" => true,
                    "error" => "Email incorrect",
                    "unicity" => true,
                    "errorUnicity" => "Un compte existe déjà avec cet email"
                ],
                "role" => [
                    "type" => "select",
                    "id" => "jjj",
                    "class" => "formRegister",
                    "options" => [
                        "data" =>
                            $roleManager->getAll(),
                        "property" => "name",
                        "value" => "id",
                        "selected" => 1

                    ]],
                "user_id" => [
                    "value" => $this->getId(),
                    "type" => "hidden",
                    "id" => "idUser",
                    "class" => "formRegister",
                    ]


            ],
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
                    "confirm" => "password",
                ],
                // "csrf_token" => [
                //     "placeholder" => $_SESSION['csrf_token'],
                //     "value" => $_SESSION['csrf_token'],
                //     "type" => "text",
                //     "id" => "pwdcsrf",
                //     "class" => "formRegister",
                //     "required" => true,
                //     "error" => "Le token csrf ne correspond pas"
                // ]
            ]
        ];
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
                // "csrf_token" => [
                //     "placeholder" => $_SESSION['csrf_token'],
                //     "value" => $_SESSION['csrf_token'],
                //     "type" => "hidden",
                //     "id" => "pwdcsrf",
                //     "class" => "formRegister",
                //     "required" => true,
                //     "error" => "Le token csrf ne correspond pas"
                // ]   
            ]
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
                    "id" => "login",
                    "class" => "fadeIn second",
                    "required" => true,
                ],
                "password" => [
                    "placeholder" => "Votre mot de passe ...",
                    "type" => "password",
                    "id" => "password",
                    "class" => "fadeIn third",
                    "required" => true,
                ]
            ]
        ];
    }


}