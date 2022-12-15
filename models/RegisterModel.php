<?php

namespace app\models;
use app\core\Application;
use app\core\Model;

/**
* The RegisterModel class would represent the database models for the user registration.
* They would be responsible for interacting with the database to create, read, update, and delete data.
*/

class RegisterModel extends Model {

    public string $username = "";
    public string $email = "";
    public string $password = "";
    public string $repeatPassword = "";

    protected function tableName(): string {
        return "users";
    }
 
    // register user method
    public function registerUser(){
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $tableName = $this->tableName();
        $data = [
            "username" => $this->username,
            "email" => $this->email,
            "password" => $this->password,
            "repeatPassword" => $this->repeatPassword
        ];
        $attributes = $this->attributes();
        $data = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).") VALUES (".implode(',', $data).")");
        foreach ($attributes as $attribute){
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();
        return true;

    }

    public function prepare($sql){
        return Application::$app->db->pdo->prepare($sql);
    }

    public function attributes(): array {
        return [
            "username",
            "email",
            "password",
        ];
        
	}

    public function rules(): array {
        return [
            "username" => [self::RULE_REQUIRED, [self::RULE_UNIQUE, "class" => self::class]],
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, "class" => self::class],],
            "password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 8]],
            "repeatPassword" => [self::RULE_REQUIRED, [self::RULE_MATCH, "match" => "password"]]
        ];
    }
}