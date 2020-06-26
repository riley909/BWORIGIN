<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
header("Content-Type: application/json; charset=UTF-8");
session_start();

$obj = json_decode($_POST["x"], false);
$conn = new mysqli("localhost", "studybahasa", "bahasa", "StudyBahasa");
mysqli_query ($conn, 'SET NAMES utf8');
$posttitle = addslashes($obj->posttitle);
$postcontent = addslashes($obj->postcontent);
$author = addslashes($obj->author);
$authorid = addslashes($obj->authorid);
$date = addslashes($obj->date);
// $categoryname = addslashes($obj->categoryname);
// $public = addslashes($obj->public);

$stmt = $conn->prepare("INSERT INTO $obj->table(postnum,posttitle,postcontent,author,date,hit,authorid)
VALUES (null,'$posttitle','$postcontent','$author','$date',0,'$authorid')");
$stmt->execute();
$sql = "select *from blog where posttitle ='$posttitle' and postcontent ='$postcontent'
and author ='$author' and date ='$date' and authorid ='$authorid'";
$res = $conn->query($sql);
if($res->num_rows > 0) {
    echo json_encode('1');
    exit();
} else {
    echo json_encode('0');
}
?>
