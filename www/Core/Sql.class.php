<?php

namespace App\Core;

use PDO;

abstract class Sql
{

    protected $pdo;
    protected $table;


    public function __construct()
    {
        //Plus tard il faudra penser au singleton
        try {
            $this->pdo = new \PDO(DBDRIVER . ":host=" . DBHOST . ";port=" . DBPORT . ";dbname=" . DBNAME, DBUSER, DBPWD
                , [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]);
        } catch (\Exception $e) {
            die("Erreur SQL : " . $e->getMessage());
        }

        $getCalledClassExploded = explode("\\", strtolower(get_called_class())); // App\Model\User
        $this->table = DBPREFIXE . end($getCalledClassExploded);
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
     * @param string $type email | id
     * @param string $param
     * @return false|mixed|object
     */

    public function getBy(string $type, string $param)
    {

        $sql = "SELECT * FROM " . $this->table . " WHERE " . $type . "=:$type";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute([$type => $param]);
        return $queryPrepared->fetchObject(get_called_class());


        /*      $sql = "SELECT * FROM ".$this->table." WHERE id=:id";
               $queryPrepared = $this->pdo->prepare($sql);
               $queryPrepared->execute( ["id"=>$id] );
               return $queryPrepared->fetchObject(get_called_class());*/

    }

    public function getLastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * @param null $id
     */
    public function getALl()
    {
        $sql = "SELECT * FROM ".$this->table;
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        return $queryPrepared->fetchAll(PDO::FETCH_CLASS, get_called_class());

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

    public function login($data)
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
            echo 'Password is valid!';
        } else {
            echo 'Invalid password.';
        }

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();

    }

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