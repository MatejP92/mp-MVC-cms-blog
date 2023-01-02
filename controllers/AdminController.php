<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;

use app\core\exception\ForbiddenException;
use app\core\exception\NotFoundException;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\models\Blog;
use app\models\User;


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
                throw new ForbiddenException();
            }
        } else {
            $userRole = "guest";
            // The user is not logged in, throw a ForbiddenException
            throw new ForbiddenException();
        }
    }

    public function newPost(Request $request){
        $id = empty($id);
        $title = isset($request->getBody()['title']) ?? "";
        $author = isset($request->getBody()['author']) ?? "";
        $content = isset($request->getBody()['content']) ?? "";
        $status = isset($request->getBody()['status']) ?? "";
        $created = "";
        $postModel = new Blog($id, $title, $author, $content, $status, $created);

        if($request->isPost()) {
            $postModel->loadData($request->getBody());
            if($postModel->validate() && $postModel->save()) {
                Application::$app->session->setFlash("success", "Your post has been saved, you can create a new post <a href='admin/new_post'>HERE</a> or you can view <a href='/admin/view_posts'>ALL POSTS</a>.");
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
        $userRole = User::findUser(["username" => Application::$app->user->getDisplayName()])->role;
        if($userRole == "admin"){
            // Show all posts
            $posts = Blog::FindAllPosts();
        } else {
            // Show only the user's posts
            $posts = Blog::FindUserPosts(Application::$app->user->getDisplayName());
        }
        $this->setLayout("admin");
        return $this->render("/view_posts", [
            "posts" => $posts
        ]);
    }


    public function editPost(Request $request)
    {
        if (empty($_GET) || !$_GET["id"]) {
            throw new NotFoundException();
        } else {
            $postId = $_GET["id"];
            $post = Blog::findPostById((int) $postId);
            if(empty($post)){
                throw new NotFoundException();
            } else {
                    $this->setLayout("admin");
                    return $this->render("/edit_post",[
                    "post" => $post,
                    "id" => $postId
                ]);
            }
        }
    }

    public function postPreview(){
        if(empty($_GET) || !$_GET["id"] || Application::isGuest()) {
            throw new NotFoundException();
        } else {
            $postId = $_GET["id"];
            $post = Blog::findPostById((int)$postId);
            if (empty($post)) {
                throw new NotFoundException();
            } else {
                if($post[0]->author === Application::$app->user->getDisplayName() || Application::$app->userRole() == "admin") {
                // Show the post
                if (!is_array($post)) {
                    $post = [$post];
                }
                $this->setLayout("admin");
                return $this->render("post", [
                    "post" => $post,
                    "id" => $postId
                ]);
                } else {
                throw new NotFoundException();
                }
            }
        }
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