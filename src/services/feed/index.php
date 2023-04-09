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

        /**
         * 
         */
        function to_array() {
            return array(
                "id" => $this->data['id'],
                "user_id" => $this->data['user_id'],
                "user_handle" => $this->data['user_handle'], 
                "display_name" => $this->data['display_name'],
                "created_date" => $this->data['reated_date'], 
                "body" => $this->data['body'],
                "has_image" =>$this->data['has_image'],
                "image_url" => $this->data['image_url'],
                "comment_count" => $this->data['comment_count'],
                "like_count" => $this->data['like_count'],
                "user_has_liked" => $this->user_has_liked
            );
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
            $feed_post_list = $this->post_service->get_feed_posts($user_id);
            $feed_items = array();

            foreach($feed_post_list as $post) {
                if ($post['user_has_liked']) {
                    $item = new Feed_Item($post, TRUE);
                    $feed_items[$post['id']] = $item->to_array();
                } else {
                    $item = new Feed_Item($post);
                    $feed_items[$post['id']] = $item->to_array();
                }
            }

            return $feed_items;
        }


    }
?>