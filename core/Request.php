<?php

namespace app\core;

/**
* class Request
* 
* @author  Matej Pal <matejpal92@gmail.com>
* @package app\core
*/

/**
* Because we don't want to directly interact with $_SERVER 
*/
 class Request {

    /**
    * Summary of getPath
    * we need to get everything from the [REQUEST_URI] and get everything before the question mark /users?id=2, so that we get only /users
    */
    public function getPath(){
        $path = $_SERVER["REQUEST_URI"] ?? "/";  // if the request URI is not presented in the path, we assume that it is the main domain (homepage)
        $position = strpos($path, "?");          // if the path has the question mark it will give us the position of the question mark in the given path
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position); // with this we get the path from position 0 to position of the question mark, so this shoud be the path (for example /users)

    }

    /**
    * Summary of method
    * @return string
    * this method gives us the request method from the $_SERVER superglobal in lowercase (GET or POST)
    */
    public function method(){
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public function isGet(){
        return $this->method() === "get";    // If the method is get we return true
    }

    public function isPost(){
        return $this->method() === "post";   // If the method is post we return true
    }

    public function getQueryParameter($pathQuery){
        return $_GET["$pathQuery"];
    }

    public function getBody() {
        $body = [];
        if($this->method() === "get") {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if($this->method() === "post") {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }

}