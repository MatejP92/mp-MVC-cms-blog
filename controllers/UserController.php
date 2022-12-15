<?php

namespace app\controllers;
use app\core\Controller;
use app\core\Request;
use app\models\User;

/** 
*  The UserController class would handle
*  user registration and login.
**/


/**
* The UserController class in this PHP MVC blog CMS might have methods such as create() to display a form for creating a new user, 
* store() to process the data from the form and add the new user to the database, edit() to display a form 
* for editing an existing user, update() to process the data from the form and update the user in the database, 
* and delete() to delete the user from the database. These methods would handle HTTP requests from the user, such as 
* submitting a form or following a link, and would use the User class to interact with the database. 
* The UserController might also have additional methods to handle user authentication and authorization.
*/

/**
* class UserController
* 
* @author  Matej Pal <matejpal92@gmail.com>
* @package app\controllers
* this class is responsible for handling the overall functionality of the site, such as rendering views and interacting with the model to retrieve data
*/

class UserController extends Controller {

    public function login(Request $request){
        $loginModel = new User();
        if($request->isPost()){
            $loginModel->loadData($request->getBody());
            echo "<pre>";
            var_dump($loginModel);
            echo "</pre>";
            exit;
        }
        return $this->render("login");
    }

    public function register(){
        // if($request->isPost()){
        //     // register the user
        // }
        return $this->render("register");
    }
}
