<?php

namespace app\models;
use app\core\Model;

/**
* The LoginModel class would represent the database models for the user.
* They would be responsible for interacting with the database to Login the user.
*/

class LoginModel extends Model {

   public string $username = "";
   public string $password = "";


   // login method

    public function login() {
      echo "login in";
   }


   public function rules(): array {
      return [
          "username" => [self::RULE_REQUIRED],
          "password" => [self::RULE_REQUIRED],
      ];
  }

}