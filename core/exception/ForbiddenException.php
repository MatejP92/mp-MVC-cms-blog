<?php

namespace app\core\exception;


/**
* class ForbiddenException
* 
* @author  Matej Pal <matejpal92@gmail.com>
* @package app\core\exception
*/

class ForbiddenException extends \Exception {

    protected $message = "You don't have permission to access this page.";
    protected $code = 403;
}