<?php
/******** IMPORTS ********/

require "./strategies/post/index.php";
require "../services/post/index.php";
require "../services/user/index.php";

require "../services/repository/post/index.php";
require "../services/repository/user/index.php";
require "../services/database/sqlite/index.php";

/******** CONSTANTS *******/

const APPLICATION_CONFIG_FILE = "../../src/config.json"; 

/******** SERVICES *******/

$sqlite_client = new SQLite_Client(APPLICATION_CONFIG_FILE);

$post_repository = new Post_Repository($sqlite_client);
$user_repository = new User_Repository($sqlite_client);

$post_service = new Post_Service($post_repository);
$user_service = new User_Service($user_repository);

/******** FORM INPUTS *******/

$rel = $_POST["rel"];

/******** MAIN *******/

$strategies = array(
    "create-post" => new Create_Post($post_service, $user_service),
    "add-comment" => new Add_Comment($post_service, $user_service),
    "like-post" => new Update_Like($post_service, $user_service)
);

class Post_Client {
    private $context;

    /**
     * See `/strategies/post/index.php`
     * @param Object $context
     */
    function set_strategy($context) {
        $this->context = $context;
    }

    /**
     * See `/strategies/post/index.php`
     * @param Object $form_data
     * @return Post_Template
     */
    function process_form_data($form_data) {
        return $this->context->process_form_data($form_data);
    }
}

$post_client = new Post_Client();
$post_client->set_strategy($strategies[$rel]);
$output = $post_client->process_form_data($_POST);

echo $output;
?>
