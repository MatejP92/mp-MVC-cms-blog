<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\User;
use app\models\LoginModel;
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;

/** 
*  The UserController class would handle
*  user registration and login.
**/


/**
* The UserController class in this PHP MVC blog CMS might have methods such as create() to display a form for creating a new user, 
* store() to process the data from the form and add the new user to the database, edit() to display a form 
* for editing an existing user, update() to process the data from the form and update the user in the database, 
* and delete() to delete the user from the database. These methods would handle HTTP requests from the user, such as 
* submitting a form or following a link, and would use the User class to interact with the database. 
* The UserController might also have additional methods to handle user authentication and authorization.
*/

/**
* class UserController
* 
* @author  Matej Pal <matejpal92@gmail.com>
* @package app\controllers
* this class is responsible for handling the overall functionality of the site, such as rendering views and interacting with the model to retrieve data
*/

class UserController extends Controller {

    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware(["profile"]));

    }

    public function login(Request $request, Response $response){
        $loginModel = new LoginModel();
        if($request->isPost()){
            $loginModel->loadData($request->getBody());
            if($loginModel->validate() && $loginModel->login()){
                $response->redirect("/");
                return;
            }
        }
        return $this->render("login", [
            "model" => $loginModel
        ]);
    }


    public function register(Request $request){
        $registerModel = new User();
        if($request->isPost()){
            $registerModel->loadData($request->getBody());            
            if($registerModel->validate() && $registerModel->save()){ // add validation: if($registerModel->validate() && $registerModel->registerUser()) {...}
                Application::$app->session->setFlash("success", "Thanks for registering");
                Application::$app->response->redirect("/");
                return;
            }
            // register the user
        }
        return $this->render("register", [
            "model" => $registerModel
        ]);
    }

    public function logout(Request $request, Response $response) {
        Application::$app->logout();
        $response->redirect("/");
    }


    public function forgotPassword(Request $request){
        $forgotPw = new User();
        if($request->isPost()){
            $forgotPw->loadData($request->getBody());
            $token = bin2hex(random_bytes(32));

            if($forgotPw->validate()){
                // Get the url protocol and base url
                $protocol = explode("/" ,$_SERVER["SERVER_PROTOCOL"]);
                $url_protocol = strtolower($protocol[0]);
                $baseUrl = $_SERVER["HTTP_HOST"];

                $dotenv = Dotenv::createImmutable(dirname(__DIR__));
                $dotenv->load();

                $mail = new PHPMailer();
                $mail->isSMTP();                                //Send using SMTP
                $mail->Host       = $_ENV["SMTP_HOST"];         //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                       //Enable SMTP authentication
                $mail->Username   = $_ENV["SMTP_USER"];
                $mail->Password   = $_ENV["SMTP_PASSWORD"];
                $mail->Port       = $_ENV["SMTP_PORT"];         //TCP port to connect to;
                $mail->SMTPSecure = "tls";                      //Enable implicit TLS encryption
       
                $mail->isHTML(true);
                $mail->CharSet    = "UTF-8";
                $mail->setFrom("reset_pw@test.com", "Reset Password");
                $mail->addAddress($forgotPw->email);
                $mail->Subject = "Reset Password";
                $resetPasswordUrl = $url_protocol . '://' . $baseUrl . '/reset_password?email=' . urlencode($forgotPw->email) . '&token=' . urlencode($token);
                $mail->Body = "To reset your password, please visit the following URL: <a href='$resetPasswordUrl'>$resetPasswordUrl</a><br>This link is valid for 30 minutes";

                if ($mail->send()) {
                    // Email sent successfully
                    if($forgotPw->forgotPassword($token, $forgotPw->email)){
                        Application::$app->session->setFlash("success", "Link for reset password has been sent to your email address");
                        Application::$app->response->redirect("/");
                        return;
                    }
                } else {
                    // An error occurred
                    $errorMessage = $mail->ErrorInfo;
                    Application::$app->session->setFlash("danger", "Sending email failed " . $errorMessage);
                }
            }
        }
        return $this->render("forgot_password", [
            "model" => $forgotPw
        ]);
    }


    public function resetPassword(Request $request){
        if($_GET["email"] && $_GET["token"] && Application::isGuest()){
            $email = $_GET["email"];
            $token = $_GET["token"];
            $user = User::findUser(["email" => $email]);
            if (empty($user)) {
                throw new NotFoundException();
            } else {
                if($token === $user->token){
                    $now = time();
                    $expire = strtotime($user->expire);
                    if ($now > $expire) {
                        Application::$app->session->setFlash("danger", "The reset password link has expired. Please try again.");
                        Application::$app->response->redirect("/forgot_password");
                        return;
                    }
                    $resetPw = new User();               
                    if($request->isPost()){
                        $resetPw->loadData($request->getBody());
                        
                        if ($resetPw->validate() && $resetPw->resetPassword($user->email)) {
                            Application::$app->session->setFlash("success", "Your password has been updated. You can now login.");
                            Application::$app->response->redirect("/login");
                        }
                    }
                }
            }
            return $this->render("reset_password", [
                "email" => $email,
                "token" => $token,
                "model" => $resetPw,
            ]);
        } else {
            throw new NotFoundException();
        }
    }
}
