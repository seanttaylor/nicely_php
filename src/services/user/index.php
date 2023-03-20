<?php

class User {
    private $id;
    private $handle;
    private $display_name;
    private $motto;
    private $follower_count = 0;
    private $email;
    private $created_date;

    /**
     * 
     */
    function __construct($id, $email, $display_name, $handle, $motto) {
        $this->id = $id;
        $this->display_name = $display_name;
        $this->handle = $handle;
        $this->email = $email;
        $this->motto = $motto;
        // See https://php.watch/versions/8.0/date-utc-p-format
        $this->created_date = date('Y-m-d\TH:i:s');

      }

    /**
     * Transforms the existing User instance to an associative array
     * @return Array
     */
    function to_array() {
        return array(
            "id" => $this->id,
            "handle" => $this->handle, 
            "display_name" => $this->display_name,
            "motto" => $this->motto,
            "follower_count" => $this->follower_count,
            "email" => $this->email,
            "created_date" => $this->created_date
        );
    }

    /**
     * Transforms the existing User instance to a JSON object
     * @return Array
     */
    function to_json() {
        return json_encode(
            array(
                "id" => $this->id,
                "handle" => $this->handle, 
                "display_name" => $this->display_name,
                "motto" => $this->motto,
                "follower_count" => $this->follower_count,
                "email" => $this->email,
                "created_date" => $this->created_date
            )
        );
    }

    /**
    * Edit motto property of an existing user in the data store.
    * @param String $motto_update - the updated motto
    */
    function edit_motto($motto_update) {

    }

    /**
    * Edits the display name on an existing user 
    * @param String $name_update - the new display name
    */
    function edit_display_name($name_update) {

    }

    /**
    * Subscribe the current user to the feed of another user on the platform
    * @param User $target_user - an instance of the User class; the user to be followed
    */
    function follow_user($target_user) {

    }

    /**
    * Unsubscribe the current user from the feed of another user on the platform
    * @param User $target_user - an instance of the User class; the user to be un-followed
    */
    function unfollow_user($target_user) {

    }

    /**
    * Returns a list of the users following the current user follows
    * @return Array
    */
    function get_followers() {

    }

    /**
    * Returns a list of users the current user is following
    * @returns Array
    */
    function follows() {

    }

}

class User_Service {
    private $repository;

    /**
     * @param Object $repository - a repository interface for connecting 
     * to a storage mechanism
     */
    function __construct($repository) {
        $this->repository = $repository;
    }

    /**
     * Creates a new User
     * @param String $handle
     * @param String $display_name
     * @param String $motto
     * @param String $email 
     * @return User
     */
    function create_user($email, $display_name, $handle, $motto) {
        $user_id = uuid();
        $user = new User($user_id, $email, $display_name, $handle, $motto);

        $this->repository->create_user($user->to_array());
        return $user;
    }

    /**
     * @param String $id - uuid of the post to fetch
     * @return Array
     */
    function get_user_by_id($id) {
        return $this->repository->get_user_by_id($id);
    }
    
}

?>
