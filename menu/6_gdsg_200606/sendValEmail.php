<?php
// error_reporting(E_ALL);
ini_set('display_errors','1');
include_once('mailer.lib.php');
session_start();

// foreach ($_POST as $id) {
//   echo $id;
// }

if(isset($_POST)){
  $id = $_POST['id'];
  $emailValCode = $_POST['emailValCode'];
  mailer("StudyBahasa", "riley909@naver.com", "$id", "[StudyBahasa] 이메일 인증 코드입니다.", "$emailValCode", 1);

  echo "해당 이메일로 인증 코드가 발송되었습니다.";
  echo $emailValCode;
}

 ?>
