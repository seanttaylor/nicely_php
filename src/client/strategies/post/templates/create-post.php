<?php
    class Post_Template {
        /**
         * Renders an HTML template
         * @param Array $template_vars - associative array of variables to inject in the template
         * @return String
         */
        static function render($template_vars) {
            list(
                "id" => $id,
                "handle" => $handle, 
                "display_name" => $display_name,
                "has_image" => $has_image,
                "image_url" => $image_url,
                "body" => $post_body, 
                "comment_count" => $comment_count,
                "like_count" => $like_count,
                "created_date" => $created_date
            ) = $template_vars;
    
            $header_content = "<div class='ui card centered'>
                <div class='content'>
                    <div class='right floated meta'>
                        <span data-publish-date='$created_date'>14h</span>
                    </div>
                    <img class='ui avatar image' src='https://placehold.it/50' data-user-avatar-image> 
                    <span data-user-handle='$handle'>$handle</span>
                </div>";

            $image_content = "<div class='image'>
                <img src='$image_url'>
            </div>";

            $body_content = "<div class='content'>
                <a class='header' data-user-display-name='$display_name'>$display_name</a>
                <div class='description'>$post_body</div>
            </div>

            <div class='content' data-post-stats=$id>
                <span class='right floated'>
                <i class='heart outline like icon'></i>
                <span data-like-count='$like_count'>$like_count</span> likes
                </span>
                <i class='comment icon'></i>
                <span data-comment-count='$comment_count'>$comment_count comments </span>
            </div>

            <div class='extra content'>
                <div class='ui large transparent left icon input'>
                    <i class='heart outline icon'></i>
                    <input type='text' placeholder='Add Comment...'>
                </div>
            </div>
        </div>";

        if ($has_image) {
            return $header_content . $image_content . $body_content;
        }

        return $header_content . $body_content;
        }
    }
?>

