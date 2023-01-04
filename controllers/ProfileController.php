<?php

namespace app\controllers;
use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Request;
use app\models\ProfileModel;
use app\models\User;


/**
 * Summary of ProfileController
 * The ProfileController class is responsible for managing the profile information
 */
class ProfileController extends Controller {

    // profile page
    public function profile(){
        if(Application::isGuest()){
            throw new NotFoundException();
        } else {
            $user = User::findUser(["username" => Application::$app->user->getDisplayName()]);
            if (empty($user)) {
                throw new NotFoundException();
            } else {
                return $this->render("profile", [
                    "user" => $user,
                ]);
            }
        }
    }


    public function editProfile(Request $request){
        if(Application::isGuest()){
            throw new NotFoundException();
        } else {
            $user = User::findUser(["username" => Application::$app->user->getDisplayName()]);
            $userId = $user->id;
            if($userId != $_GET["id"] || empty($user)){
                throw new NotFoundException();
            } else {
                $id = $user->id;
                $username = isset($request->getBody()["username"]) ?? "";
                $firstname = isset($request->getBody()["firstname"]) ?? "";
                $lastname = isset($request->getBody()["lastname"]) ?? "";
                $email = isset($request->getBody()["email"]) ?? "";

                $profileModel = new ProfileModel($id, $username, $firstname, $lastname, $email, "", "", "");
                // update profile here
                if($request->isPost()){

                    $profileModel->loadData($request->getBody());

                    if($profileModel->validate() && $profileModel->editUser()){                                             
                        Application::$app->session->setFlash("success", "Your profile has been updated");
                        Application::$app->response->redirect("/profile"); 
                    }
                }
            }
            return $this->render("edit_profile", [
                "user" => $user,
                "model" => $profileModel,
                "id" => $userId
            ]);
        }
    }


    public function changePassword(Request $request) {
    if (Application::isGuest()) {
        throw new NotFoundException();
        } else {
            $user = User::findUser(["username" => Application::$app->user->getDisplayName()]);
            $userId = $user->id;
            if ($user->id != $_GET["id"] || empty($user)) {
                throw new NotFoundException();
            } else {
                $id = $user->id;
                $password = isset($request->getBody()["password"]) ? $request->getBody()["password"] : "";
                $newPassword = isset($request->getBody()["newpassword"]) ? $request->getBody()["newpassword"] : "";
                $repeatNewPassword = isset($request->getBody()["repeatnewpassword"]) ? $request->getBody()["repeatnewpassword"] : "";
                $profileModel = new ProfileModel($id, "", "", "", "", $password, $newPassword, $repeatNewPassword);
                if ($request->isPost()) {
                    $profileModel->loadData($request->getBody());
                    if ($profileModel->validate() &&  $profileModel->editUserPassword()) {
                        Application::$app->session->setFlash("success", "Your password has been updated");
                        Application::$app->response->redirect("/profile");
                    }
                }
                return $this->render("change_password", [
                    "user" => $user,
                    "model" => $profileModel,
                    "id" => $userId
                ]);
            }
        }
    }


}