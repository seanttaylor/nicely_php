<?php

class Comment {
    public $id;
    private $post_id;
    private $user_id;
    private $body;
    private $created_date;
    private $like_count = 0;
    
    function __construct($id, $post_id, $user_id, $body) {
        $this->id = $id;
        $this->post_id = $post_id;
        $this->user_id = $user_id;
        $this->body = $body;
        // See https://php.watch/versions/8.0/date-utc-p-format
        $this->created_date = date('Y-m-d\TH:i:s');
    }

     /**
     * Transforms the existing Comment instance to an associative array
     * @return Array
     */
    function to_array() {
        return  array(
            "id" => $this->id,
            "user_id" => $this->user_id,
            "post_id" => $this->post_id, 
            "created_date" => $this->created_date, 
            "body" => $this->body,
            //"has_image" => $this->has_image,
            //"image_url" => $this->image_url,
            "like_count" => $this->like_count
        );
    }
    
    /**
     * Transforms the existing Comment instance to a JSON object
     * @return Array
     */
    function to_json() {
        return json_encode(
            array(
            "id" => $this->id,
            "post_id" => $this->post_id,
            "user_id" => $this->user_id, 
            "created_date" => $this->created_date, 
            "body" => $this->body,
            //"has_image" => $this->has_image,
            //"image_url" => $this->image_url,
            "like_count" => $this->like_count
            ), JSON_PRETTY_PRINT
        );
    }
    
    function increment_like_count() {
        $this->like_count++;
    }
    
    function decrement_like_count() {
        $this->like_count--;
    }
}

?>