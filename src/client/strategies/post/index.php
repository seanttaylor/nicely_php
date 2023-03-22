<?php
/******** IMPORTS ********/

require __DIR__ . "/templates/create-post.php";
require __DIR__ . "/templates/add-comment.php";

/**
 * Defines a strategy for the Post_Client to use for processing incoming form data
 */
class Strategy {
    protected $post_service;
    protected $user_service;

    /**
     * @param Object $post_service - an instance of the Post_Service interface
     * @param Object $user_service - an instance of the User_Service interface
     */
    function __construct($post_service, $user_service) {
        $this->post_service = $post_service;
        $this->user_service = $user_service;
    }
}


/**
 * A strategy available to the Post_Client for processing incoming 
 * form data; renders an HTML template for a new Post
 */
class Create_Post extends Strategy {

    /**
     * Processes incoming form data from the application
     * @param Object $form_data - form data from the client application
     * @return Post_Template
     */
    function process_form_data($form_data) {
        $post_body = $form_data["post-body"];
        $current_user = $this->user_service->get_user_by_id($form_data["user-id"]);
        $new_post = $this->post_service->create_post(
            $current_user["id"], 
            $current_user["handle"], 
            $current_user["display_name"], 
            $post_body
        );

        return Post_Template::render($new_post->to_array());
    } 
}

/**
 * A strategy available to the Post_Client for processing incoming 
 * form data; adds a new comment to a specified Post returning an HTML snippet to render in the DOM
 */
class Add_Comment extends Strategy {

    /**
     * Processes incoming form data from the application
     * @param Object $form_data - form data from the client application
     * @return String a JSON formatted string
     */
    function process_form_data($form_data) {
        $comment_body = $form_data["comment-body"];
        $commenting_user = $this->user_service->get_user_by_id($form_data["commenter-id"]);
        $current_post = $this->post_service->get_post_by_id($form_data["post-id"]);
        
        $this->post_service->add_comment($current_post, $commenting_user["id"], $comment_body);
        $updated_post = $this->post_service->get_post_by_id($form_data["post-id"]);
        
        return Add_Comment_Template::render($updated_post->to_array());
    } 
}

/**
 * A strategy available to the Post_Client for processing incoming 
 * form data; adds a new like to a specified Post returning an HTML snippet to render in the DOM
 */
class Update_Like extends Strategy {

    /**
     * Processes incoming form data from the application
     * @param Object $form_data - form data from the client application
     * @return String a JSON formatted string
     */
    function process_form_data($form_data) {
        if ($form_data["rel"] === "like-post") {
            $user = $this->user_service->get_user_by_id($form_data["user-id"]);
            $current_post = $this->post_service->get_post_by_id($form_data["post-id"]);
        
            $this->post_service->increment_like_count($current_post, $user);
            $updated_post = $this->post_service->get_post_by_id($form_data["post-id"]);
            $current_post_liked_by_user = TRUE;

            return Update_Like_Template::render($updated_post->to_array(), $current_post_liked_by_user);
        }
               
    } 
}

?>