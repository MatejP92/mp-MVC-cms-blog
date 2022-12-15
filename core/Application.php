<?php

namespace app\core;
use app\core\Controller;
 
/**
* class Application
* 
* @author  Matej Pal <matejpal92@gmail.com>
* @package app\core
*/

class Application {
    public static string $ROOT_DIR;
    public Request $request;
    public Router $router;
    public Response $response;
    public Database $db;
    public static Application $app;
    public Controller $controller;
    public View $view;   

    public function __construct($rootPath, array $config) {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config["db"]);
        $this->view = new View();
    }

    public function run() {
        echo $this->router->resolve();
    }

        /**
     * Summary of getController
     * @return \app\core\Controller
     */
    public function getController(): Controller {
        return $this->controller;
    }

    /**
     * Summary of setController
     * @param \app\core\Controller $controller
     */
    public function setController(Controller $controller): void {
        $this->controller = $controller;
    }
}
