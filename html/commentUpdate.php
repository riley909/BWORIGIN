<?php
require '/var/www/html/menu/db.php';
error_reporting(E_ALL);
ini_set("display_errors", 1);

$reviewNum = $_POST['reviewNum'];
$sql = queryResult("SELECT *FROM comments WHERE review_num = '$reviewNum'");

?>