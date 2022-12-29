<?php

namespace app\models;
use app\core\Model;
use PDO;


/**
* The User class would represent the database models for the user registration.
* They would be responsible for interacting with the database to create, read, update, and delete data.
*/

class ResetPassword extends Model {

    public string $email = "";
 
    

	/**
	 * @return array
	 */
	public function rules(): array {
        return [
            "password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 5]],
            "repeatPassword" => [self::RULE_REQUIRED, [self::RULE_MATCH, "match" => "password"]]
        ];
	}
}