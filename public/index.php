<?php
use app\core\Application;
use app\controllers\SiteController;
use app\controllers\UserController;
use app\controllers\AdminController;

/**
* The public/index.php file would be the entry point for the application. It would initialize 
* the application and route incoming requests to the appropriate controller.
*/

require_once __DIR__."/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$rootPath = __DIR__;

$config = [
    "userClass" => \app\models\User::class,
    "db" => [
        "dsn" => $_ENV["DB_DSN"],
        "user" => $_ENV["DB_USER"],
        "password" => $_ENV["DB_PASSWORD"],
    ]
];

$app = new Application(__DIR__, $config);

$app->router->get("/", [SiteController::class, "home"]);
$app->router->get("/posts", [SiteController::class, "posts"]);

$app->router->get("/profile", [UserController::class, "profile"]);

$app->router->get("/login", [UserController::class, "login"]);
$app->router->post("/login", [UserController::class, "login"]);

$app->router->get("/register", [UserController::class, "register"]);
$app->router->post("/register", [UserController::class, "register"]);

$app->router->get("/logout", [UserController::class, "logout"]);

$app->router->get("/admin", [AdminController::class, "admin"]);

$app->run();