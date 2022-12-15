<?php

namespace app\core;

/**
* class Controller
* 
* @author  Matej Pal <matejpal92@gmail.com>
* @package app\core
*/

class Controller{

    public string $layout = "main";
    public function setLayout(string $layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $params = []) {
        return Application::$app->view->renderView($view, $params);
    }
}