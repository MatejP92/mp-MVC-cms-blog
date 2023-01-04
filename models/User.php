<?php

namespace app\models;
use app\core\Application;
use app\core\DatabaseModel;

/**
* The User class would represent the database models for the user registration.
* They would be responsible for interacting with the database to create, read, update, and delete data.
*/

class User extends DatabaseModel {

    public string $id;
    public string $username = "";
    public ?string $firstname = null;
    public ?string $lastname = null;
    public string $email = "";
    public string $password = "";
    public string $repeatPassword = "";
    public string $role = "";
    public string $created = "";


    public static function tableName(): string {
        return "users";
    }

    public static function primaryKey(): string {
        return "id";
    }
 
    // register user method
    public function save(){
        $data = [
            "username" => $this->username,
            "email" => $this->email,
            "password" => $this->password,
            "repeatPassword" => $this->repeatPassword
        ];
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function attributes(): array {
        return [
            "username",
            "firstname",
            "lastname",
            "email",
            "password",
        ];
        
	}

    public function rules(): array {
        return [
            "username" => [self::RULE_REQUIRED, [self::RULE_UNIQUE, "class" => self::class], self::RULE_NO_SPECIAL_CHARS],
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, "class" => self::class],],
            "password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 5]],
            "repeatPassword" => [self::RULE_REQUIRED, [self::RULE_MATCH, "match" => "password"]],
        ];
    }




    // get user role method
    public function getUserRole($username): string {
        // Retrieve the user's role from the database using the findUser() method
        $user = User::findUser(["username" => "$username"]);
        return $user->role;
    }

    public function updateUserRole() {
        $role = $this->role;
        return parent::updateUserRole();
    }

    public function deleteUser(){
        return parent::deleteRecord();
    }



	public function getDisplayName(): string {
        return $this->username;
	}

    

}