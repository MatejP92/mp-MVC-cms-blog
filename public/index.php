<?php

use app\core\Application;
use app\controllers\SiteController;
use app\controllers\UserController;
use app\controllers\AdminController;
use app\controllers\ProfileController;
use app\controllers\ResetPasswordController;

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
$userRole = "guest";

$app->router->get("/", [SiteController::class, "home"]);
$app->router->get("/posts", [SiteController::class, "posts"]);
$app->router->get("/post", [SiteController::class, "post"]);


$app->router->get("/profile", [ProfileController::class, "profile"]);
$app->router->get("/edit_profile", [ProfileController::class, "editProfile"]);
$app->router->post("/edit_profile", [ProfileController::class, "editProfile"]);
$app->router->get("/change_password", [ProfileController::class, "changePassword"]);
$app->router->post("/change_password", [ProfileController::class, "changePassword"]);

$app->router->get("/login", [UserController::class, "login"]);
$app->router->post("/login", [UserController::class, "login"]);

$app->router->get("/register", [UserController::class, "register"]);
$app->router->post("/register", [UserController::class, "register"]);

$app->router->get("/logout", [UserController::class, "logout"]);


$app->router->get("/dashboard", [AdminController::class, "admin"]);
$app->router->get("/dashboard/view_posts", [AdminController::class, "viewPosts"]);
$app->router->get("/dashboard/new_post", [AdminController::class, "newPost"]);
$app->router->post("/dashboard/new_post", [AdminController::class, "newPost"]);
$app->router->get("/dashboard/edit_post", [AdminController::class, "editPost"]);
$app->router->post("/dashboard/edit_post", [AdminController::class, "editPost"]);
$app->router->get("/dashboard/post_preview", [AdminController::class, "postPreview"]);
$app->router->get("/dashboard/delete_post", [AdminController::class, "deletePost"]);

$app->router->get("/dashboard/publish_post", [AdminController::class, "changePostStatus"]); 
$app->router->get("/dashboard/unpublish_post", [AdminController::class, "changePostStatus"]);

$app->router->get("/dashboard/view_users", [AdminController::class, "viewUsers"]);
$app->router->get("/dashboard/change_role", [AdminController::class, "changeUserRole"]);
$app->router->get("/dashboard/delete_user", [AdminController::class, "deleteUser"]);
$app->router->get("/dashboard/new_user", [AdminController::class, "newUser"]);

$app->router->get("/dashboard/comments", [AdminController::class, "comments"]);


$app->router->get("/forgot_password", [UserController::class, "forgotPassword"]);
$app->router->post("/forgot_password", [UserController::class, "forgotPassword"]);
$app->router->get("/reset_password", [UserController::class, "resetPassword"]);
$app->router->post("/reset_password", [UserController::class, "resetPassword"]);


$app->run();
