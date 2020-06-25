<?php
require '/var/www/html/menu/db.php';

error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!empty($_POST)) {
    $id = $_POST['commentId'];
    $reviewNum = $_POST['reviewNum'];
    $commentContent = $_POST['commentContent'];
    $commentDate = $_POST['commentDate'];
    $commentTime = $_POST['commentTime'];
    
    $sql = queryResult("INSERT INTO comments (id,review_num,comment_content,comment_date,comment_time) 
    VALUES ('$id','$reviewNum','$commentContent','$commentDate', '$commentTime')");
}
?>
