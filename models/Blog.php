<?php

namespace app\models;
use app\core\Application;
use app\core\DatabaseModel;

/**
 * The Blog class would represent the database models for the blog posts.
 * They would be responsible for interacting with the database to create, read, update, and delete data.
 */

class Blog extends DatabaseModel {
    public int $id;
    public string $title = "";
    public string $author = "";
    public string $content = "";
    public string $created;
    public string $status = "";

    public function __construct($id, $title, $author, $content, $created, $status){
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->content = $content;
        $this->created = $created;
        $this->status = $status;
    }


    public static function tableName(): string {
        return "posts";
    }
    



    // Table columns


    // Constructor with database connection


    // Create a new post method
    public function savePost(){
        $data = [
            "title" => $this->title,
            "author" => $this->author,
            "content" => $this->content,
            "status" => $this->status,
            "created" => $this->created
        ];
        return parent::save();
    }

    // Get all blog posts
    public function getAllPosts() {
        $posts = Blog::findAllPosts();
        return $posts;
    }

    // Display posts from a user
    public function getUserPosts() {
        $posts = Blog::findUserPosts(Application::$app->user->getDisplayName());
        return $posts;
    }

    // Get all published posts
    public function getAllPublishedPosts() {
        $posts = Blog::findAllPublishedPosts();
        return $posts;
    }

    // Get all published posts from user
    public function getUserPublishedPosts() {
        $posts = Blog::findUserPublishedPosts(Application::$app->user->getDisplayName());
        return $posts;
    }

    // Get post by id method
    public function getPostById($id){
        $post = Blog::findPostById($id);
        return $post;
    }


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
            //"created"
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