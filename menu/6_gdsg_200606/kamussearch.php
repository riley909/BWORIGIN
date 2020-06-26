<?php

header("Content-Type: text/html; charset=UTF-8");
$conn = new mysqli("localhost", "studybahasa", "bahasa", "StudyBahasa");
mysqli_query($conn, 'SET NAMES utf8');

$search = $_GET['search'];

$sql = "SELECT *FROM dictionary WHERE indonesian LIKE '$search%'";
$res = $conn->query($sql);

// 사전db while문 시작
while ($row = mysqli_fetch_array($res)) {

  $indonesian = $row['indonesian'];
  $korean = $row['korean'];
  $english = $row['english'];

  echo $indonesian;
  echo $korean;
  echo $english;
}
 ?>
