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

    /**
     * Summary of newPost
     * This method is called when a post is created
     * @param Request $request
     * @return array|string
     */
    public function newPost(Request $request){
        $id = empty($id);
        $title = isset($request->getBody()['title']) ?? "";
        $author = isset($request->getBody()['author']) ?? "";
        $content = htmlspecialchars(isset($request->getBody()['content']) ?? "");
        $status = isset($request->getBody()['status']) ?? "";
        $created = "";
        $postModel = new Blog($id, $title, $author, $content, $status, $created);

        if($request->isPost()) {
            $postModel->loadData($request->getBody());
            if($postModel->validate() && $postModel->savePost()) {
                Application::$app->session->setFlash("success", "Your post has been saved, you can create a new post <a href='/dashboard/new_post'>HERE</a> or you can view <a href='/dashboard/view_posts'>ALL POSTS</a>.");
                Application::$app->response->redirect("/dashboard");      
            }
            // save the post
        }
        $this->setLayout("admin");
        return $this->render("/new_post",
            ["model" => $postModel
        ]);
    }

    /**
     * Summary of admin
     * This method is called by the user when he enters the admin section
     * @return array|string
     */
    public function admin(){
        $this->setLayout("admin");
        return $this->render("dashboard");
    }

    /**
     * Summary of ViewPosts
     * This method is called when a user wants to view created posts in a table
     * @return array|string
     */
    public function ViewPosts(){
        $userRole = User::findUser(["username" => Application::$app->user->getDisplayName()])->role;
        if($userRole == "admin"){
            // Show all posts
            $posts = Blog::FindAllPosts();
        } else {
            // Show only the user's posts
            $posts = Blog::FindUserPosts(Application::$app->user->getDisplayName());
        }
        if (!empty($posts)) {
            $posts[0]->content = strip_tags(htmlspecialchars_decode($posts[0]->content), "<p>");
        }
        
        $this->setLayout("admin");
        return $this->render("/view_posts", [
            "posts" => $posts
        ]);
    }

    /**
     * Summary of editPost
     * This method is called when a user wants to edit a post
     * @param Request $request
     * @throws NotFoundException
     * @return array|string
     */
    public function editPost(Request $request)
    {
        if (empty($_GET) || !$_GET["id"]) {
            throw new NotFoundException();
        } else {
            $postId = $_GET["id"];
            $post = Blog::findPostById((int)$postId);

            if (empty($post)) {
                throw new NotFoundException();
            } else {
                $id = $post[0]->id;
                $title = isset($request->getBody()['title']) ?? "";
                $author = isset($request->getBody()['author']) ?? "";
                $content = htmlspecialchars(isset($request->getBody()['content']) ?? "");
                $status = isset($request->getBody()['status']) ?? "";
                $created = $post[0]->created;

                $editModel = new Blog($id, $title, $author, $content, $status, $created);
                if ($request->isPost()) {
                    $editModel->loadData($request->getBody());
                    if ($editModel->validate() && $editModel->updatePost()) {
                        Application::$app->session->setFlash("success", "Post has been edited.");
                        Application::$app->response->redirect("/dashboard/view_posts");
                        //return;
                    }
                    // update the post
                }
           }
           $this->setLayout("admin");
                return $this->render("/edit_post", [
                    "model" => $editModel,
                    "post" => $post,
                    "id" => $postId
                ]);
        }
    }

    /**
     * Summary of postPreview
     * This method is called when the user wants to preview the post
     * @throws NotFoundException
     * @return array|string
     */
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
                } else {
                    throw new NotFoundException();
                }
            }
        }
        $this->setLayout("admin");
        $post[0]->content = htmlspecialchars_decode($post[0]->content);
        return $this->render("post_preview", [
            "post" => $post,
            "id" => $postId
        ]);
    }

    /**
     * Summary of changePostStatus
     * This method is called when the admin wants to change the status of a post
     * @throws NotFoundException
     * @return array|string
     */
    public function changePostStatus(){
        if (empty($_GET) || !$_GET["id"] || Application::$app->userRole() !== "admin" ) {
            throw new NotFoundException();
        } else {
            $postId = (int)$_GET["id"];
            $post = Blog::findPostById($postId);
            if (empty($post)) {
                throw new NotFoundException();
            } else {
                $postStatus = $post[0]->status;
                if($postStatus == "published") {
                    $post[0]->status = "unpublished";
                } elseif ($postStatus == "unpublished") {
                    $post[0]->status = "published";
                }
                $post[0]->updatePostStatus();   
                
            }
        }
        Application::$app->session->setFlash("success", "Post status updated");
        Application::$app->response->redirect("/dashboard/view_posts");
        return $this->ViewPosts();
    }
    
    /**
     * Summary of deletePost
     * This method is called when the user wants to delete a post
     * @throws NotFoundException
     * @return array|string
     */
    public function deletePost(){
        if (empty($_GET) || !$_GET["id"] || Application::isGuest()) {
            throw new NotFoundException();
        } else {
            $postId = (int) $_GET["id"];
            $post = Blog::findPostById($postId);
            if (empty($post)) {
                throw new NotFoundException();
            } else {
                $postObject = $post[0];
                $postObject->deletePost();
            }
        }
        Application::$app->session->setFlash("success", "Post has been deleted");
        Application::$app->response->redirect("/dashboard/view_posts");
        return $this->ViewPosts();
    }

    /**
     * Summary of viewUsers
     * This methods shows all users in a table to admin
     * @return array|string
     */
    public function viewUsers(){
        $userRole = User::findUser(["username" => Application::$app->user->getDisplayName()])->role;
        if ($userRole == "admin") {
            $users = User::findAllUsers();
        } else {
            throw new NotFoundException();
        }
        $this->setLayout("admin");
        return $this->render("/view_users",[
            "users" => $users
        ]);
    }

    public function ChangeUserRole(){
        if (empty($_GET) || !$_GET["id"] || Application::$app->userRole() !== "admin") {
            throw new NotFoundException();
        } else {
            $userId = (int)$_GET["id"];
            $user = User::findUser(["id" => $userId]);
            if (empty($user)) {
                throw new NotFoundException();
            } else {
                $userRole = $user->role;
                if($userRole == "admin") {
                $user->role = "subscriber";
            } elseif ($userRole == "subscriber") {
                $user->role = "admin";
            }
            $user->updateUserRole();
            }
        }
        Application::$app->session->setFlash("success", "User role has been updated");
        Application::$app->response->redirect("/dashboard/view_users");
        return $this->viewUsers();
    }

    /**
     * Summary of deleteUser
     * This method is called when admin wants to delete the user
     * @throws NotFoundException
     * @return array|string
     */
    public function deleteUser(){
        if (empty($_GET) || !$_GET["id"] || Application::$app->userRole() !== "admin") {
            throw new NotFoundException();
        } else {
            $userId = (int)$_GET["id"];
            $user = User::findUser(["id" => $userId]);
            if (empty($user)) {
                throw new NotFoundException();
            } else {
                $user->deleteUser();
            }
        }
        Application::$app->session->setFlash("success", "User has been deleted");
        Application::$app->response->redirect("/dashboard/view_users");
        return $this->viewUsers();
    }

    /**
     * Summary of newUser
     * This method is called when admin wants to create a new user
     * @return array|string
     */
    public function newUser(){
        $this->setLayout("admin");
        return $this->render("/new_user");
    }

    /**
     * Summary of comments
     * This method is called when admin wants to see the comments in a table
     * @return array|string
     */
    public function comments(){
        $this->setLayout("admin");
        return $this->render("/comments");
    }
}