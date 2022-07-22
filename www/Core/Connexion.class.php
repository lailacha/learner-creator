<?php

namespace App;

class Connexion
{
    private static $pdo;


    public static function getInstance(): \PDO
    {
        if (!isset(self::$pdo)) {
            self::$pdo = new \PDO(DBDRIVER . ":host=" . DBHOST . ";port=" . DBPORT . ";dbname=" . DBNAME, DBUSER, DBPWD
                , [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]);
        }
        return self::$pdo;
    }

}