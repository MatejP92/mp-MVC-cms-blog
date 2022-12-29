<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;

use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\models\Blog;


/**
* class AdminController
* 
* @author  Matej Pal <matejpal92@gmail.com>
* @package app\controllers
*/

/**
*  The AdminController class would handle all of the logic
*  for the admin dashboard, including creating and editing posts 
**/

class AdminController extends Controller {


    public function __construct($userRole)
    {
        // Check if the user is logged in
        if (!Application::$app->isGuest()) {
            // Check if the user is an admin
            if ($userRole == "admin" || $userRole == "subscriber") {
                // Register the AuthMiddleware class
                $this->registerMiddleware(new AuthMiddleware(["admin"]));
            } else {
                // The user is not an admin, throw a ForbiddenException
                throw new \app\core\exception\ForbiddenException();
            }
        } else {
            $userRole = "guest";
            // The user is not logged in, throw a ForbiddenException
            throw new \app\core\exception\ForbiddenException();
        }
    }

    public function savePost(Request $request){
        $postModel = new Blog();
        if($request->isPost()) {
            $postModel->loadData($request->getBody());
            if($postModel->validate() && $postModel->save()) {
                Application::$app->session->setFlash("success", "Your post has been saved");
                Application::$app->response->redirect("/admin");
                return;
            }
            // save the post
        }
        $this->setLayout("admin");
        return $this->render("/new_post",
            ["model" => $postModel
        ]);
    }

    

    public function admin(){
        $this->setLayout("admin");
        return $this->render("dashboard");
    }

    public function ViewPosts(){
        $this->setLayout("admin");
        return $this->render("/view_posts");
    }

    public function newPost(){
        $this->setLayout("admin");
        return $this->render("/new_post");
    }

    public function viewUsers(){
        $this->setLayout("admin");
        return $this->render("/view_users");
    }

    public function newUser(){
        $this->setLayout("admin");
        return $this->render("/new_user");
    }

    public function comments(){
        $this->setLayout("admin");
        return $this->render("/comments");
    }
}