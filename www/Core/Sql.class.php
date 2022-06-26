<?php

namespace App\Core;

use PDO;
use App\Core\Session;
use App\Model\User as userManager;

 class Sql
{

    protected static $pdo = null;
    protected $table;

    private function __construct()
    {

    }

    public function getPDO()
    {
        if (is_null(self::$pdo)) {
            try{
                self::$pdo = new \PDO( DBDRIVER.":host=".DBHOST.";port=".DBPORT.";dbname=".DBNAME.";charset=utf8mb4" , DBUSER , DBPWD, [\PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
            }catch(\Exception $e){
                die("Erreur SQL : ".$e->getMessage());
            }
    
            $getCalledClassExploded = explode("\\", strtolower(get_called_class())); // App\Model\User
            $this->table = DBPREFIXE.end($getCalledClassExploded);

        }
        return self::$pdo;
    }

  

    



    /**
     * @param null $id
     */
    public function setId(?int $id)
    {
        $sql = "SELECT * FROM ".$this->table." WHERE id=:id";

        $queryPrepared = self::$pdo->prepare($sql);
        $queryPrepared->execute( ["id"=>$id] );

        return $queryPrepared->fetchObject(get_called_class());


    }

    /**
     * @param string $type email | id
     * @param string $param
     * @return false|mixed|object
     */

    public function getBy(string $type, string $param)
    {

        $sql = "SELECT * FROM " . $this->table . " WHERE " . $type . "=:$type";

        $queryPrepared = self::$pdo->prepare($sql);
        $queryPrepared->execute([$type => $param]);
        return $queryPrepared->fetchObject(get_called_class());


        /*      $sql = "SELECT * FROM ".$this->table." WHERE id=:id";
               $queryPrepared = $this->pdo->prepare($sql);
               $queryPrepared->execute( ["id"=>$id] );
               return $queryPrepared->fetchObject(get_called_class());*/

    }

    /**
     * @return array
     */
    public function getAll()
    {
        $sql = "SELECT * FROM ".$this->table;
        $queryPrepared = self::$pdo->prepare($sql);
        $queryPrepared->execute();
        return $queryPrepared->fetchAll(PDO::FETCH_CLASS, get_called_class());

    }

    public function getOneByOne($attribute, $value){

        $sql = "SELECT * FROM ".$this->table." WHERE ".$attribute."=:value";
        $queryPrepared = self::$pdo->prepare($sql);
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

        $queryPrepared = self::$pdo->prepare($sql);
        $queryPrepared->execute( $attributes);
        return $queryPrepared->fetchObject(get_called_class());
    }

    public function getLastInsertId(): string
    {
        return self::$pdo->lastInsertId();
    }


    /**
     * @param string $field
     * @param string $value
     * @return array
     */
    public function getAllBy(string $field, string $value): array
    {
        $sql = "SELECT *" . " FROM " . $this->table . " WHERE " . $field . "=:$field";
        $queryPrepared = self::$pdo->prepare($sql);
        $queryPrepared->execute([$field => $value]);
        return $queryPrepared->fetchAll(PDO::FETCH_CLASS, get_called_class());
    }


    public function delete() :void
    {
        $sql = "DELETE FROM ".$this->table." WHERE id=:id";
        $queryPrepared = self::$pdo->prepare($sql);
        $queryPrepared->execute( ["id"=>$this->getId()] );
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
        
        $queryPrepared = self::$pdo->prepare($sql);
       
        $queryPrepared->execute($colums);
        


        //Si ID null alors insert sinon update
    }

/*    public function login($data)
    {

        $bdd = new \PDO(DBDRIVER . ":host=" . DBHOST . ";port=" . DBPORT . ";dbname=" . DBNAME, DBUSER, DBPWD
            , [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]);

        $value = $data[key($data)];
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