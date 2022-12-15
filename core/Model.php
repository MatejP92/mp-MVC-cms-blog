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
                    $this->addError($attribute, self::RULE_REQUIRED);
                }
                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                    $this->addError($attribute, self::RULE_EMAIL);
                }
                if($ruleName === self::RULE_MIN and strlen($value) < $rule["min"]) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }
                if($ruleName === self::RULE_MATCH and $value !== $this->{$rule["match"]}) {
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }
                if($ruleName === self::RULE_UNIQUE){
                    $className = $rule["class"];
                    $uniqueAttr = $rule["attribute"] ?? $attribute;
                    $tableName = $className::tableName();
                    $statement = self::prepare("SELECT * FROM $tableName WHERE $uniqueAttr=:attr");
                    $statement->bindValue(":attr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record) {
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, ["field" => $this->getLabel($attribute)]);
                    }
                }
            }
        }

        return empty($this->errors);
    }

    public function prepare($sql){
        return Application::$app->db->pdo->prepare($sql);
    }

    private function addErrorForRule(string $attribute, string $rule, $params = []){

        $message = $this->errorMessages()[$rule] ?? "";
        foreach($params as $key => $value){
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }
    public function addError(string $attribute, string $rule, $params = []) {
        $message = $this->errorMessages()[$rule] ?? "";
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages() {
        return [
            self::RULE_REQUIRED => "This field is required",
            self::RULE_EMAIL    => "This field must be a valid email address",
            self::RULE_MIN      => "Minimum length of the password must be at least {min} characters",
            self::RULE_MATCH    => "Passwords do not match",
            self::RULE_UNIQUE   => "{field} already exists",
        ];
    }

    public function hasError($attribute){
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError ($attribute) {
        return $this->errors[$attribute][0] ?? false;
    }
}