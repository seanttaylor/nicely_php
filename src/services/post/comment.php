<?php

class Comment {
    public $id;
    private $user_id;
    private $text;
    private $date;
    private $likes = 0;
    
    function __construct($user_id, $text, $id) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->text = $text;
        // See https://php.watch/versions/8.0/date-utc-p-format
        $this->date = date('Y-m-d\TH:i:s');
    }
    
    function increment_like_count() {
        $this->likes++;
    }
    
    function decrement_like_count() {
        $this->likes--;
    }
}

?>