<?php

namespace app\core;

/**
* class Database
* 
* @author  Matej Pal <matejpal92@gmail.com>
* @package app\core
*/


class Database {

    public \PDO $pdo;

    public function __construct(array $config) {

        $dsn = $config["dsn"] ?? "";
        $user=  $config["user"] ?? "";
        $password =  $config["password"]?? "";
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); // if there is some problem regarding the database, throw the exception
    }

}