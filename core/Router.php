<?php

namespace app\core;

use app\core\exception\NotFoundException;

/**
* class Router
* 
* @author  Matej Pal <matejpal92@gmail.com>
* @package app\core
*/

 class Router {

    public Request $request;
    public Response $response;
    protected array $routes = [];

    /**
    * Summary of __construct
    * @param Request $request
    * @param Response $response
    */
    public function __construct(Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;
    }


    /** METHODS FOR GET OR POST ACTIONS */
    public function get($path, $callback){
        $this->routes["get"][$path] = $callback;
    }
    public function post($path, $callback){
        $this->routes["post"][$path] = $callback;
    }

    /**
    * Summary of resolve
    * This method gets the path and the method of the request
    */
    public function resolve(){
        $path = $this->request->getPath();      // this request gives us only the path without the question mark
        $method = $this->request->method();  // this request gives us only the method (get or post)

        $callback = $this->routes[$method][$path] ?? false; // for the given method (get or post) and the given path(/home, /login, ...) we want to get the callback for the given path
        if ($callback === false) {  // if the callback is false we just echo Not found, that means that the page was not found - it doesn't exist (/login exists ->$callback is true, /asdf doesn't exist ->$callback is false)
            throw new NotFoundException();
        }
        if(is_string($callback)){   // if the callback is a string it will return the renderView($callback) -> this method will render the page
            return Application::$app->view->renderView($callback);
        }
        if (is_array($callback)) {
            /**
            * @var \app\core\Controller $controller
            */
            if(Application::$app->isGuest()){
                $userRole = "guest";
                $controller = new $callback[0]($userRole);
            } else {
                $userModel = new \app\models\User();
            
                $userRole = $userModel->getUserRole(Application::$app->user->getDisplayName());
                $controller = new $callback[0]($userRole);
            }
            //$userRole = "admin"; // get the user role from logged in user
            //$controller = new $callback[0]($userRole); // we create a new instance of the callback and we take from the callback the first element, which is the Controller name and create a new instance of the Controller with a new keyword
            Application::$app->controller = $controller;
            $controller->action = $callback[1]; // index 1 is the action, in index.php we have [userController::class, "profile"] : profile is on index 1 and this is the action
            $callback[0] = $controller;
            foreach($controller->getMiddlewares() as $middleware){
                $middleware->execute();
            }
        }

        return call_user_func($callback, $this->request, $this->response); // this function executes the callback and it will return the string
    }


}