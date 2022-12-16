<?php

namespace app\core;

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
            $this->response->setStatusCode(404);      // this sets the status code to 404, because the page was not found
            return Application::$app->view->renderView("_404");   //
        }
        if(is_string($callback)){   // if the callback is a string it will return the renderView($callback) -> this method will render the page
            return Application::$app->view->renderView($callback);
        }
        if (is_array($callback)) {
            Application::$app->controller = new $callback[0](); // we create a new instance of the callback and we take from the callback the first element, which is the Controller name and create a new instance of the Controller with a new keyword
            $callback[0] = Application::$app->controller;
        }

        return call_user_func($callback, $this->request, $this->response); // this function executes the callback and it will return the string
    }


}