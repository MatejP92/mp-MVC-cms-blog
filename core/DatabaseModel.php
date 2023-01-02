<?php

namespace app\core;
use app\models\Blog;
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


    
    
    static public function findAllPosts() {
        $posts = [];
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName ORDER BY id DESC");
        $statement->execute();
        $rows = $statement->fetchAll();
        foreach($rows as $row) {
            $posts[] = new Blog($row["id"], $row["title"], $row["author"], substr($row["content"], 0, 200), $row["created"], $row["status"]);
        }
        return $posts;
    }
   
    static public function findAllPublishedPosts(){
        $posts = [];
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE status = :status ORDER BY id DESC");
        $statement->bindValue(":status", "published");
        $statement->execute();
        $rows = $statement->fetchAll();
        foreach($rows as $row) {
            $posts[] = new Blog($row["id"], $row["title"], $row["author"], substr($row["content"], 0, 200), $row["created"], $row["status"]);
        }
        return $posts;
    }

    
    static public function findUserPosts($userDisplayName){
        $posts = [];
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE author = :username ORDER BY id DESC");
        $statement->bindValue(":username", $userDisplayName);
        $statement->execute();
        $rows = $statement->fetchAll();
        foreach($rows as $row) {
            $posts[] = new Blog($row["id"], $row["title"], $row["author"], substr($row["content"], 0, 200), $row["created"], $row["status"]);
        }
        return $posts;
    }

    static public function findUserPublishedPosts($userDisplayName){
        $posts = [];
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE author = :username AND status = :status ORDER BY id DESC");
        $statement->bindValue(":username", $userDisplayName);
        $statement->bindValue("status", "published");
        $statement->execute();
        $rows = $statement->fetchAll();
        foreach($rows as $row) {
            $posts[] = new Blog($row["id"], $row["title"], $row["author"], substr($row["content"], 0, 200), $row["created"], $row["status"]);
        }
        return $posts;
    }

    static public function findPostById(int $id){
        $post = [];
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE id = :id");
        $statement->bindValue(":id", $id, \PDO::PARAM_INT);
        $statement->execute();
        $rows = $statement->fetchAll();
        foreach($rows as $row) {
            $post[] = new Blog($row["id"], $row["title"], $row["author"], $row["content"], $row["created"], $row["status"]);
        }
        return $post;
    }


    static public function getId(){
        $id = $_GET["id"];
        $tableName = static::tableName();
        $statement = self::prepare("SELECT id FROM $tableName WHERE id = :id");
        $statement->bindValue(":id", $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchColumn();
    }


    public static function prepare($sql){
        return Application::$app->db->pdo->prepare($sql);
    }

    abstract public function getDisplayName(): string;
}