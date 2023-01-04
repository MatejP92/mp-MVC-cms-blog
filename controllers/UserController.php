<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\User;
use app\models\LoginModel;

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

    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware(["profile"]));
    }

    public function login(Request $request, Response $response){
        $loginModel = new LoginModel();
        if($request->isPost()){
            $loginModel->loadData($request->getBody());
            if($loginModel->validate() && $loginModel->login()){
                $response->redirect("/");
                return;
            }
        }
        return $this->render("login", [
            "model" => $loginModel
        ]);
    }


    public function register(Request $request){
        $registerModel = new User();
        if($request->isPost()){
            $registerModel->loadData($request->getBody());            
            if($registerModel->validate() && $registerModel->save()){ // add validation: if($registerModel->validate() && $registerModel->registerUser()) {...}
                Application::$app->session->setFlash("success", "Thanks for registering");
                Application::$app->response->redirect("/");
                return;
            }
            // register the user
        }
        return $this->render("register", [
            "model" => $registerModel
        ]);
    }

    public function logout(Request $request, Response $response) {
        Application::$app->logout();
        $response->redirect("/");
    }


    public function forgotPassword(){
        return $this->render("forgotpassword");
    }

}
