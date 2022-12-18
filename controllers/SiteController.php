<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;

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
            $params = [
                "name" => "Guest"
            ];
        } else {
            $params = [
                "name" => Application::$app->user->getDisplayName()
            ];
        }
        return $this->render("home", $params);  // this replaces the Application::$app->router->renderView("home", $params); 
        // render method is created in Controller class in core folder
    }

    public function posts(){
        return $this->render("posts");
    }
}