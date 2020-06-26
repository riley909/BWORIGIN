<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();

$conn = new mysqli("localhost", "studybahasa", "bahasa", "StudyBahasa");
mysqli_query ($conn, 'SET NAMES utf8');
$sql = "select *from blog where posttitle ='$posttitle' and postcontent ='$postcontent'
and author ='$author' and date ='$date'";
$res = $conn->query($sql);
if($res->num_rows > 0) {
    echo json_encode('1');
    exit();
} else {
    echo json_encode('0');
}
?>
