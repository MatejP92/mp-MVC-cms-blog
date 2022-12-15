<?php

namespace app\models;
use app\core\Model;

/**
* The User class would represent the database models for the user.
* They would be responsible for interacting with the database to create, read, update, and delete data.
*/

class User extends Model {

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


    


}