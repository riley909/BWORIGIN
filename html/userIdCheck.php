<?php
require '/var/www/html/menu/db.php';
header("Content-Type: application/json; charset=UTF-8");
$obj = json_decode($_POST['content'], false);
$sql = queryResult("SELECT *FROM user WHERE id = '$obj->id'");
if($sql->num_rows > 0){
  // 아이디값이 존재하면 1전송
  echo json_encode('1');
  exit();
}else {
  // 존재하지 않으면 0전송
  echo json_encode('0');
}
 ?>
