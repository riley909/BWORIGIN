<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
include_once('mailer.lib.php');
header("Content-Type: text/html; charset=UTF-8");
$conn = new mysqli("localhost", "studybahasa", "bahasa", "StudyBahasa");
mysqli_query($conn, 'SET NAMES utf8');
if($conn->connect_errno){
  printf("Connect failed: %s\n", $conn->connect_error);
  exit();
}

// 랜덤문자열 생성 함수
function random_char($length){
  $characters = "0123456789";
  $characters.= "abcdefghijklmnopqrstuvwxyz";
  $characters.= "ABCDEFGHIJKLMNOPQRSTUVWXY";

  $string_generated = "";
  $nmr_loops = $length;

  while($nmr_loops--){
    $string_generated.= $characters[mt_rand(0, strlen($characters) -1)];
  }
  return $string_generated;
}
$temp_pwd = random_char(10);

$id = $_POST['id'];
$name = $_POST['name'];

$sql = "select *from member where id = '$id' and name = '$name'";
$res = $conn->query($sql);
$row = mysqli_fetch_array($res);

if($res->num_rows > 0){
  // db에 있을 경우 메일발송
  // 보내는 사람이름, 보내는사람 메일주소, 받는사람 메일주소, 제목, 내용, 1
  mailer("StudyBahasa", "riley909@naver.com", "$id", "[StudyBahasa] 임시 비밀번호입니다.", "$temp_pwd", 1);
  $sql1 = "UPDATE member SET pwd = '$temp_pwd' WHERE id = '$id'";
  $res1 = $conn->query($sql1);
  echo "<script>alert('임시 비밀번호가 발송되었습니다.');</script>";
  echo "<script>window.close();</script>";

}else {
  echo "<script>alert('회원 정보가 존재하지 않습니다.'); location.href='/stdbhs/templ/findPwd.html'</script>";
  exit();
}

 ?>
