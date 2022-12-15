<?php

namespace app\core;

/**
* class View
* 
* @author  Matej Pal <matejpal92@gmail.com>
* @package app\core
*/


class View {

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