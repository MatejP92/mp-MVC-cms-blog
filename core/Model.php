<?php

namespace app\core;


/**
* class Model
* 
* @author  Matej Pal <matejpal92@gmail.com>
* @package app\core
*/

abstract class Model {

    /**
    * Validation rule that specifies a value is required
    */
    public const RULE_REQUIRED = 'required';

    /**
    * Validation rule that specifies a value must be a valid email address
    */
    public const RULE_EMAIL = 'email';

    /**
    * Validation rule that specifies a minimum length for a value
    */
    public const RULE_MIN = 'min';

    /**
    * Validation rule that specifies a value must match some other value
    */
    public const RULE_MATCH = 'match';
    /**
    * Validation rule that specifies a value must not already exist
    */
    public const RULE_UNIQUE = "unique";
    /**
    * Validation rule that specifies a value must not already exist
    */
    public const RULE_EXISTS = "exists";
    /**
    * Validation rule that prevents the use of special characters
    */
    public const RULE_NO_SPECIAL_CHARS = "no_special_chars";
    /**
     * Validation rule that validates the password
     */
    public const RULE_PW_VALIDATE = "pw_validate";
    /**
    * Validation rule that specifies a value must not match some other value
    */
    public const RULE_NO_MATCH = 'no_match';

    public function loadData($data) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;
    public array $errors = []; // this array will gather all the errors

    public function labels(): array {
        return [];
    }

    public function getLabel($attribute){
        return $this->labels()[$attribute] ?? $attribute;
    }

    public function validate(){
        // this method validates the inputed data

        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach($rules as $rule){
                $ruleName = $rule;
                if(!is_string($ruleName)){
                    $ruleName = $rule[0];
                }
                if($ruleName === self::RULE_REQUIRED && !$value){ // if rulename is equal to required and the value doesn't exist, this means that there is a validation error of required
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }
                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }
                if($ruleName === self::RULE_MIN && strlen($value) < $rule["min"]){
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }
                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule["match"]}){
                    $rule["match"] = $this->getLabel($rule["match"]);
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }
                if($ruleName === self::RULE_NO_MATCH && $value == $this->{$rule["match"]}){
                    $rule["match"] = $this->getLabel($rule["match"]);
                    $this->addErrorForRule($attribute, self::RULE_NO_MATCH, $rule);
                }
                if($ruleName === self::RULE_NO_SPECIAL_CHARS && preg_match('/[^A-Za-z0-9]/', $value)){
                    $this->addErrorForRule($attribute, self::RULE_NO_SPECIAL_CHARS);
                }
                if($ruleName === self::RULE_UNIQUE){
                    $className = $rule["class"];
                    $uniqueAttr = $rule["attribute"] ?? $attribute;
                    $tableName = $className::tableName();
                    $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr=:attr");
                    $statement->bindValue(":attr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record) {
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, ["field" => $this->getLabel($attribute)]);
                    }
                }
                if($ruleName === self::RULE_EXISTS){
                    $className = $rule["class"];
                    $uniqueAttr = $rule["attribute"] ?? $attribute;
                    $tableName = $className::tableName();
                    $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr=:attr");
                    $statement->bindValue(":attr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if (!$record) {
                        $this->addErrorForRule($attribute, self::RULE_EXISTS, ["field" => $this->getLabel($attribute)]);
                    }
                }
                if($ruleName === self::RULE_PW_VALIDATE){
                    $className = $rule["class"];
                    $uniqueAttr = "id"; // Set $uniqueAttr to "id"
                    $tableName = $className::tableName();
                    $statement = Application::$app->db->prepare("SELECT password FROM $tableName WHERE $uniqueAttr=:attr");
                    $statement->execute(["attr" => $this->$uniqueAttr]);
                    $record = $statement->fetchObject();
                    if (!$record) {
                        // Add an error if the provided attribute value is not found in the database
                        $this->addErrorForRule($attribute, self::RULE_PW_VALIDATE, ["field" => $this->getLabel($attribute)]);
                    } else {
                        // Check if the provided password matches the encrypted password in the database
                        if (!password_verify($this->$attribute, $record->password)) {
                            $this->addErrorForRule($attribute, self::RULE_PW_VALIDATE, ["field" => $this->getLabel($attribute)]);
                        }
                    }
                }
                
            }
        }
        return empty($this->errors);
    }

    private function addErrorForRule(string $attribute, string $rule, $params = []){

        $message = $this->errorMessages()[$rule] ?? "";
        foreach($params as $key => $value){
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }
    public function addError(string $attribute, string $message){ // this method takes only 2 arguments that will add the message inside the errors for that attribute
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages() {
        return [
            self::RULE_REQUIRED => "This field is required",
            self::RULE_EMAIL    => "This field must be a valid email address",
            self::RULE_MIN      => "Minimum length of the password must be at least {min} characters",
            self::RULE_MATCH    => "This field must be the same as {match}",
            self::RULE_NO_MATCH    => "This field must not be the same as {match}",
            self::RULE_UNIQUE   => "Record with this {field} already exists",
            self::RULE_EXISTS => "This email does not exist",
            self::RULE_NO_SPECIAL_CHARS  => "No special characters are allowed",
            self::RULE_PW_VALIDATE => "Current password is incorrect",
        ];
    }

    public function hasError($attribute){
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError ($attribute) {
        return $this->errors[$attribute][0] ?? false;
    }


}