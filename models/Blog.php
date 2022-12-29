<?php

namespace app\models;
use app\core\Application;
use app\core\DatabaseModel;

/**
 * The Blog class would represent the database models for the blog posts.
 * They would be responsible for interacting with the database to create, read, update, and delete data.
 */

class Blog extends DatabaseModel {
    public string $title = "";
    public string $author = "";
    public string $status = "";
    public string $content = "";

    public static function tableName(): string {
        return "posts";
    }
    
    // Database connection


    // Table columns


    // Constructor with database connection


    // Create a new post method
    public function savePost(){
        $data = [
            "title" => $this->title,
            "author" => $this->author,
            "content" => $this->content,
            "status" => $this->status,
        ];
        return parent::save();
    }

    // Get all blog posts


    // getById method


    // update method


    // delete method
    
    /**
     * @return array
     */
    public function attributes(): array {
        return [
            "title",
            "author",
            "content",
            "status",
        ];
    }

    public function rules(): array {
        return [
            "title" => [self::RULE_REQUIRED],
            "content" => [self::RULE_REQUIRED],
        ];
    }

	/**
	 * @return string
	 */
	public function getDisplayName(): string {
        return $this->username;
	}
}