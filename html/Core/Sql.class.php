<?php

namespace App\Core;

use PDO;
use App\Core\Session;
use App\Model\User as userManager;
use App\Core\QueryBuilder;


 class Sql
{

    protected $pdo;
    protected $table;
    protected  static $instance;

    public function __construct()
    {

        try{
            $this->pdo = new \PDO( DBDRIVER.":host=".DBHOST.";port=".DBPORT.";dbname=".DBNAME.";charset=utf8mb4" , DBUSER , DBPWD
                , [\PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);

        }catch(\Exception $e){
            die("Erreur SQL : ".$e->getMessage());
        }

        $getCalledClassExploded = explode("\\", strtolower(get_called_class())); // App\Model\User
        $this->table = DBPREFIXE.end($getCalledClassExploded);
    }



    /**
     * @param null $id
     */
    public function setId(?int $id)
    {
        $sql = "SELECT * FROM ".$this->table." WHERE id=:id";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute( ["id"=>$id] );

        return $queryPrepared->fetchObject(get_called_class());


    }

    

    /**
     * @param string $type
     * @param string $param
     * @return false|mixed|object
     */

    public function getBy(string $type, string $param)
    {

        $sql = "SELECT * FROM " . $this->table . " WHERE " . $type . "=:$type";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute([$type => $param]);
        return $queryPrepared->fetchObject(get_called_class());

    }

    public function initdb()
    {
        $sql = "CREATE DATABASE".DBNAME;
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();

        /* $esgi_commentaire_lesson=
        "
        CREATE TABLE `esgi_commentaire_lesson` (
          `id` int NOT NULL,
          `content` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
          `user` int NOT NULL,
          `lesson` int NOT NULL,
          `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `reports` int DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
        ";
        $queryPrepared = $this->pdo->prepare($esgi_commentaire_lesson);
        $queryPrepared->execute();

        
        $insert ="INSERT INTO `esgi_commentaire_lesson` (`id`, `content`, `user`, `lesson`, `created_at`, `reports`) VALUES
        (1, '<p>test</p>', 59, 41, '2022-05-14 10:52:30', NULL),
        (2, '<p>zfzefz</p>', 59, 41, '2022-05-14 10:52:57', NULL),
        (3, '<p>zfzefz</p>', 59, 41, '2022-05-14 10:53:16', NULL),
        (4, '<p>Je suis un commentaire</p>', 59, 41, '2022-05-14 11:51:46', NULL),
        (5, '<p>Test</p>', 59, 34, '2022-05-14 11:52:35', NULL),
        (6, '<p>Je suis un commentaire</p>', 59, 34, '2022-05-14 12:05:34', NULL),
        (7, '<p>Pas terrible ce cours</p>', 59, 31, '2022-05-14 12:08:45', NULL),
        (8, '<p>Bzzzz</p>', 59, 49, '2022-05-14 12:10:01', NULL),
        (9, '<p>commentaire</p>', 59, 32, '2022-05-14 12:24:03', NULL),
        (10, '<p>test</p>\r\n<p>&nbsp;</p>', 59, 16, '2022-05-14 15:05:20', NULL),
        (11, '<p>Test</p>', 59, 49, '2022-05-17 21:14:28', NULL),
        (12, '<p>Test</p>', 59, 50, '2022-05-18 17:43:13', NULL),
        (13, '<p>TEST TEST&nbsp;</p>', 65, 50, '2022-06-23 08:23:39', NULL);";
        $queryPrepared = $this->pdo->prepare($insert);
        $queryPrepared->execute();
        
 */    }
    
    public function getOneSpecif(string $col,string $cond, string $result)
    {

        $sql = "SELECT "  . $col .  " FROM " . $this->table  ."  WHERE  " . $cond  . " = " . $result;
         $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        return $queryPrepared->fetchObject(get_called_class());
    }

    /**
     * @return array
     */
    public function getAll($strict = false, $class = true)
    {
        $sql = "SELECT * FROM ".$this->table;
        $strict ? $sql .= " WHERE deleted_at IS NULL" : null;
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        if($class) {
            return $queryPrepared->fetchAll(PDO::FETCH_CLASS, get_called_class());
        }else{
            return $queryPrepared->fetchAll();
        }
    }
    public function getAllValue($attribute, $value)
    {
        $sql = "SELECT * FROM ".$this->table." WHERE ".$attribute."=:value";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute( ["value"=>$value] );
        $res = $queryPrepared->fetchAll(PDO::FETCH_CLASS, get_called_class());
        return $res;

    }
    public function getOneByOne($attribute, $value){

        $sql = "SELECT * FROM ".$this->table." WHERE ".$attribute."=:value";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute( ["value"=>$value] );
        return $queryPrepared->fetchObject(get_called_class());
    }


    public function getOneByMany($attributes){

        $where = "";
        end($attributes);
        $endAttributes = key($attributes);
        foreach ($attributes as $key=>$value) {
            $where .= $key."=:".$key;
            if($key !== $endAttributes)
                $where .= " AND ";
        }
        $sql = "SELECT * FROM ".$this->table." WHERE ".$where."";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute( $attributes);
        return $queryPrepared->fetchObject(get_called_class());
    }

    public function getLastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }


    /**
     * @param string $field
     * @param string $value
     * @return array
     */
    public function getAllBy(string $field, string $value, $strict = false): array
    {
        $sql = "SELECT *" . " FROM " . $this->table . " WHERE " . $field . "=:$field";
        $strict ? $sql .= " AND deleted_at IS NULL" : "";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute([$field => $value]);
        return $queryPrepared->fetchAll(PDO::FETCH_CLASS, get_called_class());
    }


    public function search(string $field, string $value): array
    {

        $sql = "SELECT * FROM {$this->table} WHERE {$field} LIKE :$field";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->bindValue(":$field", "%$value%");
        $queryPrepared->execute();
        //fetch an array to json
        return $queryPrepared->fetchAll();
    }


     public function delete() :void
    {
        $sql = "DELETE FROM ".$this->table." WHERE id=:id";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute( ["id"=>$this->getId()] );
    }

    public function getBySlug($slug) 
    {

        $sql = "SELECT * FROM {$this->table} WHERE slug LIKE :slug";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->bindValue(":slug", "%$slug%");
        $queryPrepared->execute();
        //fetch an array to json
        $res = $queryPrepared->fetchAll(PDO::FETCH_CLASS, get_called_class());
         if($res)
         {
            return $res;
         }
         else
            {
                return null;
            }
    }

    public function save(): void
    {
        $colums = get_object_vars($this);
        $varToExclude = get_class_vars(get_class());
        $colums = array_diff_key($colums, $varToExclude);
        
        if (is_null($this->getId())) {
            $sql = "INSERT INTO " . $this->table . " (" . implode(",", array_keys($colums)) . ") VALUES (:" . implode(",:", array_keys($colums)) . ")";
            

        } else {
            $update = [];
            foreach ($colums as $key => $value) {
                $update[] = $key . "=:" . $key;
            }
            $sql = "UPDATE " . $this->table . " SET " . implode(",", $update) . " WHERE id=:id";
        }

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute($colums);

        //Si ID null alors insert sinon update
    }

/*    public function login($data)
    {

        $bdd = new \PDO(DBDRIVER . ":host=" . DBHOST . ";port=" . DBPORT . ";dbname=" . DBNAME, DBUSER, DBPWD
            , [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]);

        $value = $data[key($data)];
        var_dump($data);
        $email = htmlspecialchars($value);
        $sql = "SELECT * FROM " . $this->table . " WHERE " . key($data) . " = '" . $value . "'";
        $sql1 = "SELECT password FROM " . $this->table . " WHERE " . key($data) . " = '" . $value . "'";
        $reponse = $bdd->query($sql);
        $donnees = $reponse->fetch();
        //var_dump($donnees);

        $reponse1 = $bdd->query($sql1);
        $donnees1 = $reponse1->fetch();



        if (password_verify($_POST["password"], $donnees1[0])) {
            $session = new Session();
            $userManager = new UserManager();
            $user = $userManager->getBy("email", $value);
            $user->setId($donnees['id']);
            $session->set("user", $donnees);
            echo 'Password is valid!';
        } else {
            echo 'Invalid password.';
        }

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();

    }*/

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTable(string $table): void
    {
        $this->table = $table;
    }


}