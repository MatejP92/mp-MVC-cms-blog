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
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public ?DatabaseModel $user; // ? means that if the user is guest, this value is null
    public View $view;   
    public string $layout = "main";
    public static Application $app;
    public ?Controller $controller = null;

    public function __construct($rootPath, array $config) {
        $this->userClass = $config["userClass"];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();

        $this->db = new Database($config["db"]);
        
        $primaryValue = $this->session->get("user");
        if($primaryValue){
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findUser([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }
  
    public function run() {
        try{
            echo $this->router->resolve();
        } catch (\Exception $e){
            $this->response->setStatusCode($e->getCode());      // this sets the status code to whatever code it is, so that it matches the error
            echo $this->view->renderView("_error", [
                "exception" => $e
            ]);
        }


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

    public function login(DatabaseModel $user){
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set("user", $primaryValue);
        return true;
    }

    public function logout(){
        $this->user = null;
        $this->session->remove("user");
    }

    public static function isGuest(){
        return !self::$app->user;
    }

    public function UserRole() {
        $userModel = new \app\models\User();
        $userRole = $userModel->getUserRole(Application::$app->user->getDisplayName());
        return $userRole;
    }

}
