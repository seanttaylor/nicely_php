<?php

class Update_Like_Template {
    /**
     * Renders an HTML template
     * @param Array $template_vars - associative array of variables to inject in the template
     * @return String
     */
    static function render($template_vars, $current_post_liked_by_user) {
        extract($template_vars);

        $like_icon = $current_post_liked_by_user ? "<i data-post-id='$id' class='heart outline like icon'></i>" : "<i data-post-id='$id' class='heart like icon'></i>";

        return "<span class='right floated'>" . $like_icon . "
            <span data-like-count>
                $like_count likes 
            </span> 
        </span>";
    }
}
?>