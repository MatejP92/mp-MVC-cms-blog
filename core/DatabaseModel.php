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
    

    /******************** GENERAL DATABASE METHODS ********************/

    /**
     * Summary of save
     * This method creates a new row in the database table with the given attributes
     * @return bool
     */
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

    /**
     * Summary of update
     * This method updates the rows in the database table with the given attributes
     * @return bool
     */
    public function update()  {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $set = implode(',', array_map(function($attr, $param) {
            return "$attr = $param";
        }, $attributes, $params));
    
        $statement = Application::$app->db->prepare("UPDATE $tableName SET $set WHERE id = :id");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->bindValue(":id", $this->id);
        $statement->execute();
        return true;
    }

    /**
    * Summary of getId
    * This method returns the id of the requested record in a database table
    * @return mixed
    */
    static public function getId(){
        $id = $_GET["id"];
        $tableName = static::tableName();
        $statement = self::prepare("SELECT id FROM $tableName WHERE id = :id");
        $statement->bindValue(":id", $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchColumn();
    }

     /**
     * Summary of deleteRecord
     * This method deletes a record/row in a database table
     * @return bool
     */
    public function deleteRecord(){
        $tableName = $this->tableName();
        $statement = Application::$app->db->prepare("DELETE FROM $tableName WHERE id = :id");
        $statement->bindValue(":id", $this->id);
        $statement->execute();
        return true;
    }
    

    /**
     * Summary of prepare
     * This method returns the prepared statement for the database
     * @param mixed $sql
     * @return \PDOStatement|bool
     */
    public static function prepare($sql){
        return Application::$app->db->pdo->prepare($sql);
    }

    /**
     * Summary of getDisplayName
     * This method returns the display name of the logged in user
     * @return string
     */
    abstract public function getDisplayName(): string;
    

    /******************** GENERAL DATABASE METHODS END ********************/


   
    /******************** USER DATABASE METHODS ********************/

    /**
     * Summary of findUser
     * This method finds a user in a database
     * @param mixed $where
     * @return bool|object
     */
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


    public function updateProfile($data) {
        $tableName = $this->tableName();
        $statement = Application::$app->db->prepare("UPDATE $tableName SET username = :username, firstname = :firstname, lastname = :lastname, email = :email WHERE id = :id");
        $statement->bindValue(":id", $data["id"]);
        $statement->bindValue(":username", $data["username"]);
        $statement->bindValue(":firstname", $data["firstname"]);
        $statement->bindValue(":lastname", $data["lastname"]);
        $statement->bindValue(":email", $data["email"]);
        $statement->execute();
        return true;
    }


    public function updatePassword($data){
        $tableName = $this->tableName();
        $statement = Application::$app->db->prepare("UPDATE $tableName SET password = :password WHERE id = :id OR email = :email");
        $statement->bindValue(":password", $data["password"]);
        $statement->bindValue(":id", $data["id"]);
        $statement->bindValue(":email", $data["email"]);
        $statement->execute();
        return true;
    }    

    /**
     * Summary of findAllUsers
     * This method finds all users in a database
     * @return array<User>
     */
    static public function findAllUsers() {
        $users = [];
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName ORDER BY id ASC");
        $statement->execute();
        $users = $statement->fetchAll();
        return $users;
    }

    public function updateUserRole(){
        $tableName = $this->tableName();
        $statement = Application::$app->db->prepare("UPDATE $tableName SET role = :role WHERE id = :id");
        $statement->bindValue(":role", $this->role);
        $statement->bindValue(":id", $this->id);
        $statement->execute();
        return true;
    }

    public function forgotenPassword($token, $email) {
        $tableName = $this->tableName();
        $expire = time() + 1800;
        $expireDatetime = date('Y-m-d H:i:s', $expire);
        $statement = Application::$app->db->prepare("UPDATE $tableName SET token = :token, expire = :expire WHERE email = :email");
        $statement->bindValue(":token", $token);
        $statement->bindValue(":expire", $expireDatetime);
        $statement->bindValue(":email", $email);
        $statement->execute();
        return true; 
    }

    

    /******************** USER DATABASE METHODS END ********************/


    /******************** POST DATABASE METHODS ********************/

    /**
     * Summary of findAllPosts
     * This method finds all posts in a database
     * @return array<Blog>
     */
    static public function findAllPosts() {
        $posts = [];
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName ORDER BY id DESC");
        $statement->execute();
        $rows = $statement->fetchAll();
        foreach($rows as $row) {
            $posts[] = new Blog($row["id"], $row["title"], $row["author"], htmlspecialchars_decode(substr($row["content"], 0, 200)), $row["created"], $row["status"]);
        }
        return $posts;
    }
   
    /**
     * Summary of findAllPublishedPosts
     * This method finds all published posts in a database
     * @return array<Blog>
     */
    static public function findAllPublishedPosts(){
        $posts = [];
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE status = :status ORDER BY id DESC");
        $statement->bindValue(":status", "published");
        $statement->execute();
        $rows = $statement->fetchAll();
        foreach($rows as $row) {
            $posts[] = new Blog($row["id"], $row["title"], $row["author"], htmlspecialchars_decode(substr($row["content"], 0, 200)), $row["created"], $row["status"]);
        }
        return $posts;
    }

    /**
     * Summary of findUserPosts
     * This method finds all posts from a logged in user in a database
     * @param mixed $userDisplayName
     * @return array<Blog>
     */
    static public function findUserPosts($userDisplayName){
        $posts = [];
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE author = :username ORDER BY id DESC");
        $statement->bindValue(":username", $userDisplayName);
        $statement->execute();
        $rows = $statement->fetchAll();
        foreach($rows as $row) {
            $posts[] = new Blog($row["id"], $row["title"], $row["author"], htmlspecialchars_decode(substr($row["content"], 0, 200)), $row["created"], $row["status"]);
        }
        return $posts;
    }

    /**
     * Summary of findUserPublishedPosts
     * This method finds all published posts from a logged in user in a database
     * @param mixed $userDisplayName
     * @return array<Blog>
     */
    static public function findUserPublishedPosts($userDisplayName){
        $posts = [];
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE author = :username AND status = :status ORDER BY id DESC");
        $statement->bindValue(":username", $userDisplayName);
        $statement->bindValue("status", "published");
        $statement->execute();
        $rows = $statement->fetchAll();
        foreach($rows as $row) {
            $posts[] = new Blog($row["id"], $row["title"], $row["author"], htmlspecialchars_decode(substr($row["content"], 0, 200)), $row["created"], $row["status"]);
        }
        return $posts;
    }

    /**
     * Summary of findPostById
     * This method finds the post with the given id
     * @param int $id
     * @return array<Blog>
     */
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

     /**
     * Summary of updatePostStatus
     * This metdhod is used to update the status of a post
     * @return bool
     */
    public function updatePostStatus(){
        $tableName = $this->tableName();
        $statement = Application::$app->db->prepare("UPDATE $tableName SET status = :status WHERE id = :id");
        $statement->bindValue(":status", $this->status);
        $statement->bindValue(":id", $this->id);
        $statement->execute();
        return true;
        }

    /******************** POST DATABASE METHODS END ********************/

}