<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\ForbiddenException;
use app\core\exception\NotFoundException;
use app\core\Response;
use app\models\Blog;
use app\models\User;

/**
* class SiteController
* 
* @author  Matej Pal <matejpal92@gmail.com>
* @package app\controllers
*
*  The SiteController class would 
*  handle displaying posts on the blog
*
*/

class SiteController extends Controller {
    
    public function home(){
        if(Application::isGuest()){
            $posts = [];
        } else {
            $posts = Blog::findUserPublishedPosts(Application::$app->user->getDisplayName());
            $posts[0]->content = htmlspecialchars_decode($posts[0]->content);
        }
        return $this->render("home", [
            "posts" => $posts
        ]);  // this replaces the Application::$app->router->renderView("home", $params); 
        // render method is created in Controller class in core folder
    }

    // Show all published posts on the blog
    public function posts(){
        $posts = Blog::findAllPublishedPosts();
        $posts[0]->content = htmlspecialchars_decode($posts[0]->content);
        return $this->render("posts", [
            "posts" => $posts
        ]);
    }

    // Show the full content of the selected post on the blog
    public function post(){
        if(empty($_GET) || !$_GET["id"]) {
            throw new NotFoundException();
        } else {
            $postId = $_GET["id"];
            $post = Blog::findPostById((int)$postId);

            // Add if the post status is unpublished to show 404 error
            
            if($post[0]->status == "unpublished") {
                throw new NotFoundException();
            } else {
            // Show the post
            if (!is_array($post)) {
                $post = [$post];
            }  
            $post[0]->content = htmlspecialchars_decode($post[0]->content);
            return $this->render("post", [
                "post" => $post,
                "id" => $postId
            ]);
            }
        }
    }



}