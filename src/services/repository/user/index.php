<?php

class User_Repository {
    private $client;

    /**
     * @param {Object} sql_client - an interface for SQL-based storage 
     */
    function __construct($sql_client) {
        $this->client = $sql_client->get_handle();
    }

    /**
     * Fetches a specified User from the database
     * @param String $id - uuid for a User
     * @return Array
     */
    function get_user_by_id($id) {
        $get_user_sql = "SELECT * FROM users WHERE id = '$id'";

        try {
            $query_result = $this->client->query($get_user_sql);

            while ($row = $query_result->fetchArray(SQLITE3_ASSOC)) {
                $users[] = $row;
            }
            return $users[0];

        } catch(Exception $e) {
            echo "There was an error getting posts";
        }
    }
}

?>