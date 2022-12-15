<?php

namespace app\models;
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

    public function tableName($tableName): string {
        return $tableName;
    }
 
    // register user method
    public function registerUser(){
        $tableName = $this->tableName("users");
        $data = [
            "username" => $this->username,
            "email" => $this->email,
            "password" => $this->password,
            "repeatPassword" => $this->repeatPassword
        ];
        echo "registering user";


    }


    public function rules(): array {
        return [
            "username" => [self::RULE_REQUIRED],
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL],
            "password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 8]],
            "repeatPassword" => [self::RULE_REQUIRED, [self::RULE_MATCH, "match" => "password"]]
        ];
    }
}