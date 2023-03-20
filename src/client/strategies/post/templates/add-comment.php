<?php

class Add_Comment_Template {
    /**
     * Renders an HTML template
     * @param Array $template_vars - associative array of variables to inject in the template
     * @return String
     */
    static function render($template_vars) {
        extract($template_vars);
        return "<span data-comment-count='$comment_count'>$comment_count comments</span>";
    }
}
?>