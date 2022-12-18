<?php

namespace app\core\exception;


/**
* class NotFoundException
* 
* @author  Matej Pal <matejpal92@gmail.com>
* @package app\core\exception
*/

class NotFoundException extends \Exception {

    protected $message = "Page not found";
    protected $code = 404;
}
   

