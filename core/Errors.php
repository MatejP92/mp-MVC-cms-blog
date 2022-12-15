<?php

class Errors
{
    /**
    * @var array An array of error messages
    */
    protected $errors = [];

    /**
    * Constructor
    *
    * @param array $errors An array of error messages
    */
    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    /**
    * Check if there are any errors for the given field
    *
    * @param string $field The field to check for errors
    *
    * @return bool True if there are errors for the field, false otherwise
    */
    public function hasErrors(string $field): bool
    {
        return isset($this->errors[$field]);
    }

    /**
    * Get the error message for the given field
    *
    * @param string $field The field to get the error message for
    *
    * @return string The error message for the field
    */
    public function getError(string $field): string
    {
        return $this->errors[$field] ?? "";
    }

    public function errorMessage(){
        return [
        "username" => "The username is required",
        "password" => "The password is required",
        "email"    => "The email is required",
        ];
    }


}



    // $errors = new Errors([
    //     "username" => "The username is required",
    //     "password" => "The password is required",
    //     "email"    => "The email is required",
    // ]);

