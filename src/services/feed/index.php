<?php

    class Feed_Item {
        public $data;
        public $user_has_liked;


        /**
         * 
         */
        function __construct($post, $user_has_liked=FALSE) {
            $this->data = $post;
            $this->user_has_liked = $user_has_liked;
        }
    }

    class Feed_Service {
        private $post_service;
        private $user_service;

        /**
         * 
         */
        function __construct($post_service, $user_service) {
            $this->post_service = $post_service;
            $this->user_service = $user_service;
        }

        /**
         * @param String $user_id
         * @param Array
         */
        function get_feed_by_user_id($user_id) {
            $user_post_list = $this->post_service->get_posts_by_user_id($user_id);
            $user_liked_posts_list = array_keys($this->post_service->get_liked_posts_by_user_id($user_id));
            $feed_items = array();

            print_r($user_liked_posts_list);
            
            foreach($user_post_list as $post) {
                if (array_key_exists($post['id'], $user_liked_posts_list)) {
                    $feed_items[$post['id']] = new Feed_Item($post, TRUE); 
                } else {
                    $feed_items[$post['id']] = new Feed_Item($post);
                }
            }

            return $feed_items;
        }


    }
?>