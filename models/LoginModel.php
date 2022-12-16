<?php

namespace app\models;
use app\core\Application;
use app\core\Model;
use app\models\User;

/**
* The LoginModel class would represent the database models for the user.
* They would be responsible for interacting with the database to Login the user.
*/

class LoginModel extends Model {

    public string $username = "";
    public string $password = "";

     // login method
    public function tableName(): string {
        return "users";
    }

    public function login() {
        $user = User::findUser(["username" => $this->username]); // this method finds the user by username
        if(!$user){ // add an error message to display that the user doesn't exist
            $this->addError("username", "User with this username doesn't exist");
            return false;
        }
        if(!password_verify($this->password, $user->password)){
            $this->addError("password", "Incorrect password");
            return false;
        }
        return Application::$app->login($user);
    }


    public function rules(): array {
        return [
            "username" => [self::RULE_REQUIRED],
            "password" => [self::RULE_REQUIRED],
            ];
    }
}