<?php

class Like {
    public $id;
    public $user_id;
    public $post_id;
    public $created_date;

    function __construct($id, $user_id, $post_id, $created_date)  {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->post_id = $post_id;
        $this->created_date = $created_date;
    }

}

?>