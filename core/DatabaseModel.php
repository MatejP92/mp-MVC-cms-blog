<?php

namespace app\core;
use app\models\User;

/**
 * Class DatabaseModel
 * 
 * @author Matej Pal <matejpal92@gmail.com>
 * @package app\core
*/

abstract class DatabaseModel extends Model{
    abstract public static function tableName(): string;
    abstract public function attributes(): array;
    public static function primaryKey(): string{
        return 'id';
    }
    
    public function save(){
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $data = array_map(fn($attr) => ":$attr", $attributes);
        $statement = Application::$app->db->prepare("INSERT INTO $tableName (".implode(',', $attributes).") VALUES (".implode(',', $data).")");
        foreach ($attributes as $attribute){
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    // public function savePost(){
    //     $tableName = "posts";
    //     $attributes = $this->attributes();
    //     $data = array_map(fn($attr) => ":$attr", $attributes);
    //     $stmt = Application::$app->db->prepare("INSERT INTO $tableName (title, author, content, status) VALUES (".implode(',', $data).")");
    //     foreach ($attributes as $attribute){
    //         $stmt->bindValue(":$attribute", $this->{$attribute});
    //     }
    //     $stmt->execute();
    //     return true;
    // }

    static public function findUser($where){ // [username => <database username>,]...
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr)=>"$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach($where as $key => $item){
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function prepare($sql){
        return Application::$app->db->pdo->prepare($sql);
    }

    abstract public function getDisplayName(): string;

}