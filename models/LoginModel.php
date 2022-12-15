<?php

namespace app\models;
use app\core\Model;

/**
* The LoginModel class would represent the database models for the user.
* They would be responsible for interacting with the database to create, read, update, and delete data.
*/

class LoginModel extends Model {

   public string $username = "";
   public string $password = "";



   // register user method


   // update user method


   // delete user method


   // login method

    public function login() {
      echo "login in";
   }

   //logout method


   // is logged in method


   // is admin method


   public function rules(): array {
      return [
          "username" => [self::RULE_REQUIRED],
          "password" => [self::RULE_REQUIRED],
      ];
  }


}