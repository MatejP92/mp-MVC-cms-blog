<?php

namespace app\models;
use app\core\Application;
use app\core\Model;

/**
* The User class would represent the database models for the user.
* They would be responsible for interacting with the database to read, update, and delete data.
*/


class User extends Model {

    public function tableName($tableName): string {
        return $tableName;
    }

    
    public function prepare($sql){
        return Application::$app->db->pdo->prepare($sql);
    }

    // update user method


    // delete user method


    //logout method


    // is logged in method


    // is admin method



	/**
	 * @return array
	 */
	public function rules(): array {
		return parent::rules();
	}
}