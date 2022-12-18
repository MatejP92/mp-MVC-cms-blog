<?php

namespace app\controllers;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;

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
    
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware(["admin"]));
    }

    public function admin(){
        $this->setLayout("admin");
        return $this->render("admin");
    }
}