<?php
//See https://www.reddit.com/r/PHP/comments/8n819d/uuids_are_obsolete/
function uuid() {
    return bin2hex(random_bytes(16));
}

?>