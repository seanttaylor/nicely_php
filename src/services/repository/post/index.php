<?php

class Post_Repository {
    private $client;

    /**
     * @param Object sql_client - an interface for SQL-based storage 
     */
    function __construct($sql_client) {
        $this->client = $sql_client->get_handle();
    }

    /**
     * Creates a new Post
     * @param Array $post - a user post
     */
    function create_post($post) {
        extract($post);

        $insert_sql = "INSERT INTO posts (id, user_id, user_handle, body, display_name, created_date, has_image) 
        VALUES ('$id', '$user_id', '$user_handle', '$body', '$display_name', '$created_date', '$has_image');";

        try {
            $this->client->exec($insert_sql);
        } catch(Exception $e) {
            echo "There was an error creating a new post";
        }
    }

    /**
     * Fetches all posts from the database
     * @return Array
     */
    function get_all_posts() {
        $get_posts_sql = "SELECT * FROM posts";
        $posts = array();

        try {
            $query_result = $this->client->query($get_posts_sql);
            while ($row = $query_result->fetchArray(SQLITE3_ASSOC)) {
                $posts[] = $row;
            }
            return $posts;

        } catch(Exception $e) {
            echo "There was an error getting posts";
        }
    }

    /**
     * Adds a comment to a specified Post
     * @param Array $comment - a Comment on a Post
     * 
     */
    function add_comment($comment) {
        extract($comment);

        $add_comment_sql = "INSERT into comments (id, post_id, user_id, body, created_date, like_count) VALUES ('$id', '$post_id', '$user_id', '$body', '$created_date', '$like_count');";

        $increment_comment_sql = "UPDATE posts SET comment_count = comment_count + 1 WHERE id = '$post_id';";

        try {
            $this->client->query($add_comment_sql);
            $this->client->query($increment_comment_sql);
        } catch(Exception $e) {
            echo "There was an error getting posts";
        }
    }

    /**
     * Adds a like to a specified Post
     * @param Array $post a Post
     * 
     */
    function increment_like_count($post) {
        extract($post);

        $increment_like_count_sql = "UPDATE posts SET like_count = like_count + 1 WHERE id = '$id';";

        try {
            $this->client->query($increment_like_count_sql);
        } catch(Exception $e) {
            echo "There was an error incrementing post like count";
        }
    }

     /**
     * Removes a like from a specified Post
     * @param Array $post a Post
     * 
     */
    function decrement_like_count($post) {
        extract($post);

        $decrement_like_count_sql = "UPDATE posts SET like_count = like_count - 1 WHERE id = '$id';";

        try {
            $this->client->query($decrement_like_count_sql);
        } catch(Exception $e) {
            echo "There was an error decrementing post like count";
        }
    }

    /**
     * Fetches a specified Post from the database
     * @param String $id - uuid for a Post
     * @return User
     */
    function get_post_by_id($id) {
        $get_post_sql = "SELECT * FROM posts WHERE id = '$id'";

        try {
            $query_result = $this->client->query($get_post_sql);

            while ($row = $query_result->fetchArray(SQLITE3_ASSOC)) {
                $posts[] = $row;
            }
            return $posts[0];

        } catch(Exception $e) {
            echo "There was an error getting posts";
        }
    }

}

?>