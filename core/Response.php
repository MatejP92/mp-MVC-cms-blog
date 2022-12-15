<?php

namespace app\core;

/**
 * class Response
 * 
 * @author  Matej Pal <matejpal92@gmail.com>
 * @package app\core
 */

 class Response {
    public function setStatusCode(int $code){

        http_response_code($code);  // this function sets the status code to whatever you want it to be (200-OK, 404-not found,...)
    }

 }