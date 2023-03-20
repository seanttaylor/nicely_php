<?php
/******** IMPORTS ********/

require "comment.php";
require __DIR__ . "../../../utils/uuid.php";

class Post {
    public $id;
    private $user_id;
    private $user_handle;
    private $body;
    private $display_name = "George Spelvin";
    private $created_date;
    private $has_image = FALSE;
    private $image_url;
    private $comment_count = 0;
    private $like_count = 0;
    
    /**
     * @param String $id - the uuid of the Post
     * @param String $display_name - the display name of the User creating the post
     * @param String $user_id - the uuid of the User creating the post
     * @param String $user_handle - the handle of the User creating the post
     * @param String|NULL $image_url - a url for any image associated with the post
     * @param String $body - text of the post
     */
    function __construct($id, $user_id, $body, $display_name, $user_handle, $image_url) {
      $this->id = $id;
      $this->display_name = $display_name;
      $this->user_id = $user_id;
      $this->user_handle = $user_handle;
      $this->body = $body;
      // See https://php.watch/versions/8.0/date-utc-p-format
      $this->created_date = date('Y-m-d\TH:i:s');

      if ($image_url) {
        $this->image_url = $image_url;
        $this->has_image = TRUE;
      }  
    }
    
    /**
     * Transforms the existing Post instance to an associative array
     * @return Array
     */
    function to_array() {
        return  array(
            "id" => $this->id,
            "user_id" => $this->user_id,
            "user_handle" => $this->user_handle, 
            "display_name" => $this->display_name,
            "created_date" => $this->created_date, 
            "body" => $this->body,
            "has_image" => $this->has_image,
            "image_url" => $this->image_url,
            "comment_count" => $this->comment_count,
            "like_count" => $this->like_count
        );
    }
    
    /**
     * Transforms the existing Post instance to a JSON object
     * @return Array
     */
    function to_json() {
        return json_encode(
            array(
            "id" => $this->id,
            "user_id" => $this->user_id,
            "user_handle" => $this->user_handle, 
            "display_name" => $this->display_name,
            "created_date" => $this->created_date, 
            "body" => $this->body,
            "has_image" => $this->has_image,
            "image_url" => $this->image_url,
            "comment_count" => $this->comment_count,
            "like_count" => $this->like_count
            ), JSON_PRETTY_PRINT
        );
    }
    
    /**
     * Updates the body of the current post 
     * @param String - $updated_text
     */
    function edit_text($updated_text) {
        $this->body = $updated_text;
    }
    
    /**
     * Removes a comment on the current post
     * @param String $comment_id - the uuid of the comment to remove
     */
    function remove_comment($comment_id) {
        //$this->comments[$comment_id] = null;
        $this->comment_count--;
    }
    
    /**
     * Increases the like_count on the current post
     */
    function increment_like_count() {
        $this->like_count+=1;
    }
    
    /**
     * Decreases the like count on the current post
     */
    function decrement_like_count() {
        $this->like_count--;
    }
    
    /**
     * Fetches alll the comments associated with the current Post
     * @return Array
     */
    function get_all_comments() {
        //return $this->comments;   
    }
    
    /**
     * 
     */
    function __destruct() {
        //echo "destroying..." . $this->id . "\n";
    }
} 

class Post_Service {
    private $posts = array();
    private $repository;

    /**
     * @param Object $repository - a repository interface for connecting to a storage mechanism
     */
    function __construct($repository) {
       $this->repository = $repository;
    }
    
    /**
     * Creates a new Post
     * @param String $user_id
     * @param String $user_handle
     * @param String $display_name
     * @param String $body
     * @param String $image_url
     * @return Post
     */
    function create_post($user_id, $user_handle, $display_name, $body, $image_url=NULL) {
        $post_id  = uuid();
        $user_post = new Post($post_id, $user_id, $body, $display_name, $user_handle, $image_url);
        
        $this->repository->create_post($user_post->to_array());
        return $user_post;
    }
    
    /**
     * Fetches all Posts in the database
     */
    function get_all_posts() {
        return $this->repository->get_all_posts();
    }
    
    /**
     * @param String $id - uuid of the post to fetch
     */
    function get_post_by_id($id) {
        $post_data = $this->repository->get_post_by_id($id);
        extract($post_data);
        return new Post($id, $user_id, $body, $display_name, $user_handle, $image_url);
    }
    
    /**
     * Updates an existing post
     * @param Object $post_instance - existing post instance to update
     */
    function update_post($post_instance) {
        //$this->repository->update_post($post_instance);
       $this->posts[$post_instance->id] = $post_instance->to_array();
    }

    /**
     * Adds a comment to specified Post
     * @param Post $current_post_id - the uuid of the Post
     * @param String $commenting_user_id - the uuid of the author of the comment
     * @param String $comment_body - the text of the comment
     */
    function add_comment($current_post_id, $commenting_user_id, $comment_body) {
        $comment_id = uuid();
        $comment = new Comment($comment_id, $current_post_id, $commenting_user_id, $comment_body);
        $this->repository->add_comment($comment);
    }
    
}

?>