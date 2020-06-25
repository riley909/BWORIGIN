<?php
require '/var/www/html/menu/db.php';
error_reporting(E_ALL);
ini_set("display_errors", 1);

$sql = queryResult("DELETE FROM comments WHERE review_num = '$reviewNum' AND comment_content = '$commentContent'");

?>