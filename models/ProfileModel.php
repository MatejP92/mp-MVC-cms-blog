<?php

namespace app\models;
use app\core\Application;
use app\core\DatabaseModel;


class ProfileModel extends DatabaseModel {

    public int $id;
    public string $username = "";
    public string $firstname = "";
    public string $lastname = "";
    public string $email = "";
    public string $password = "";
    public string $newpassword = "";
    public string $repeatnewpassword = "";

    public function __construct($id, $username, $firstname, $lastname, $email, $password, $newpassword, $repeatnewpassword) {
        $this->id = $id;
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->newpassword = $newpassword;
        $this->repeatnewpassword = $repeatnewpassword;

    }

    public static function tableName(): string {
        return "users";
    }

    public function editUser() {
        $data = [
            "id" => $this->id,
            "username" => $this->username,
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "email" => $this->email
            ];
        return parent::updateProfile($data);
    }


    public function editUserPassword(){
        $data = [
            "id" => $this->id,
            "password" => $this->newpassword,
        ];
        $data["password"] = password_hash($this->newpassword, PASSWORD_DEFAULT);
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();
        return parent::updatePassword($data);
    }



    public function rules(): array
    {
        $user = User::findUser(["username" => Application::$app->user->getDisplayName()]);
        $rules = [];
        if(Application::$app->request->getPath() === "/edit_profile"){
            $rules = [
                "firstname" => [self::RULE_NO_SPECIAL_CHARS],
                "lastname" => [self::RULE_NO_SPECIAL_CHARS],
            ];
        
            if ($this->username !== $user->username) {
                $rules["username"] = [self::RULE_REQUIRED, [self::RULE_UNIQUE, "class" => self::class], self::RULE_NO_SPECIAL_CHARS];
            }
            if ($this->email !== $user->email) {
                $rules["email"] = [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, "class" => self::class]];
            }       
        } elseif (Application::$app->request->getPath() === "/change_password"){
            $rules = [
                "password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 5], [self::RULE_PW_VALIDATE, "class" => self::class]],
                "newpassword" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 5], [self::RULE_NO_MATCH, "match" => "password"]],
                "repeatnewpassword" => [self::RULE_REQUIRED, [self::RULE_MATCH, "match" => "newpassword"]]
            ];
        }
        return $rules;
    }
    
	/**
	 * @return array
	 */
	public function attributes(): array {
        return [
            "username",
            "firstname",
            "lastname",
            "email",
            
        ];
	}
	
	/**
	 * Summary of getDisplayName
	 * This method returns the display name of the logged in user
	 * @return string
	 */
	public function getDisplayName(): string {
        return $this->username;
	}
 
}