<?php

namespace app\core\middlewares;

// this middleware classes are responsible for handling the authentication of the user and allow or deny access to the certain pages

/**
* class BaseMiddleware
* 
* @author  Matej Pal <matejpal92@gmail.com>
* @package app\core\middlewares
*/

abstract class BaseMiddleware {
    abstract public function execute();
}