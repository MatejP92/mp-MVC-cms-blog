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
            return $this->renderView("_404");   //
        }
        if(is_string($callback)){   // if the callback is a string it will return the renderView($callback) -> this method will render the page
            return $this->renderView($callback);
        }
        if (is_array($callback)) {
            Application::$app->controller = new $callback[0](); // we create a new instance of the callback and we take from the callback the first element, which is the Controller name and create a new instance of the Controller with a new keyword
            $callback[0] = Application::$app->controller;
        }

        return call_user_func($callback, $this->request); // this function executes the callback and it will return the string
    }

    /**
     * Summary of renderView
     * This method renders the page that from the given path
     * we want to render the view inside the layouts folder
     * like login.php, register.php, ...
     */
    public function renderView($view, $params =[]){

        $layoutContent = $this->layoutContent();
        $viewContent = $this->RenderOnlyView($view, $params);
        return str_replace("{{content}}", $viewContent, $layoutContent);
    }

    public function renderContent($viewContent){

        $layoutContent = $this->layoutContent();
        return str_replace("{{content}}", $viewContent, $layoutContent);
    }

    /**
     * Summary of layoutContent
     * This method sets the basic html tags and layout in main.php so the {{content}} can be rendered
     */
    protected function layoutContent(){
        $layout = Application::$app->controller->layout;
        ob_start();      // this function starts the output caching
        include_once Application::$ROOT_DIR . "/../views/layouts/$layout.php";
        return ob_get_clean(); // this function returns the value as a string, what is already buffered and clears the buffer
    }

    /**
     * Summary of RenderOnlyView
     * This method renders only the .php files in views folder
     */
    protected function RenderOnlyView($view, $params){
        foreach ($params as $key => $value) {
            $$key = $value;     // if $key is evaluated as name, $$key will be evaluated as a name variable
            // $key can be evaluated as some other variable also
        }
        //** Whenever we include the $view file, the include will see the above variables */
        ob_start();      // this function starts the output caching
        include_once Application::$ROOT_DIR . "/../views/$view.php";
        return ob_get_clean(); // this function returns the value as a string, what is already buffered and clears the buffer
    }


}