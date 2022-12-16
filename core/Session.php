<?php 

namespace app\core;

/**
* class Session
* 
* @author  Matej Pal <matejpal92@gmail.com>
* @package app\core
*/


class Session {

    /**
    * Summary of Session
    * 
    * The session is empty in beggining
    * We call the setFlash method and redirect the user
    * as soon as the user is redirected the construct method starts execution
    * it iterates over the flash messages and marks each flash message to be removed
    * we have this modified flash messages array, where we set the remove true
    * and we send this back to the $_SESSION variable
    * after this we iterate over the flash messages in destruct method
    * and if the $flashMessage["remove"] = true, we unset $flashMessage for the given key
    * 
    * When we mark something to be removed and redirect the user, on that request we might set some other 
    * session, which should not be removed, thats why we set the remove true, and in destruct method we set it to false
    */
    protected const FLASH_KEY = "flash_messages";
    public function __construct() {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? []; // if it's not set get the empty array
        foreach ($flashMessages as $key => &$flashMessage){
            // mark to be removed
            $flashMessage["remove"] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;

        
    }

public function setFlash($key, $message){

    // we want to have a unique key for flash messages
        $_SESSION[self::FLASH_KEY][$key] = [
            "remove" => false,
            "value" => $message
        ]; 

}


    public function getFlash($key) {
        // we return from session flash_key for the given key, the value, if that doesn't exists return false
        return $_SESSION[self::FLASH_KEY][$key]["value"] ?? false;
    }

    public function set($key, $value){
        $_SESSION[$key] = $value;
    }

    public function get($key){
            return $_SESSION[$key] ?? false;
        }

    public function remove($key){
        unset($_SESSION[$key]);
    }

    public function __destruct() {
        // iterate over marked to be removed flash messages and remove them
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? []; // if it's not set get the empty array
        foreach ($flashMessages as $key => &$flashMessage){
            if($flashMessage["remove"]){
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

}