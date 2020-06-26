<?php
header("Content-Type: text/html; charset=UTF-8");
$conn = new mysqli("localhost", "studybahasa", "bahasa", "StudyBahasa");
mysqli_query($conn, 'SET NAMES utf8');

// js console.log를 php로 옮김
function console_log($data){
  echo "<script>console.log('PHP_CONSOLE : ".$data."');</script>";
}

$id = $_POST['id'];
$confirmValCodeHidden = $_POST['confirmValCodeHidden'];
console_log($confirmValCodeText);
$name = $_POST['name'];
$nameHidden = $_POST['nameHidden'];
$nickname = $_POST['nickname'];
$nickNameHidden = $_POST['nickNameHidden'];
$phonenum = $_POST['phonenum'];
$phoneNumHidden = $_POST['phoneNumHidden'];
$pwd = $_POST['pwd'];
$pwdHidden = $_POST['pwdHidden'];
$id_question = $_POST['idQuestion'];
$id_answer = $_POST['idAnswer'];


if($confirmValCodeHidden != 1){
  echo "<script>alert('이메일 인증을 진행해 주세요.'); location.href='/stdbhs/templ/join.php';</script>";
  // echo "<script>alert('".$confirmValCodeHidden."'); location.href='/stdbhs/templ/join.php';</script>";

  exit();
}

if($nameHidden != 1) {
echo "<script>alert('이름을 다시 입력해 주세요.'); location.href='/stdbhs/templ/join.php';</script>";
exit();
}

if($nickNameHidden == 1) {
$sql1 = "select *from member where nickname = '$nickname'";
$res1 = $conn->query($sql1);
  if($res1 -> num_rows > 0) {
   echo "<script>alert('이미 존재하는 닉네임입니다.'); location.href='/stdbhs/templ/join.php'</script>";
   exit();
  }
} else {
echo "<script>alert('닉네임 양식이 올바르지 않습니다.'); location.href='/stdbhs/templ/join.php'</script>";
exit();
}

// if($phoneNumHidden == 1) {
// echo "<script>alert('전화번호 제출 양식이 올바르지 않습니다.'); location.href='/stdbhs/templ/join.php';</script>";
// exit();
// }

if($pwdHidden != 1) {
echo "<script>alert('비밀번호 제출 양식이 올바르지 않습니다.'); location.href='/stdbhs/templ/join.php';</script>";
exit();
}


$sql = "INSERT INTO member (id, name, nickname, pwd, id_question, id_answer, pic_name_ori, pic_name_saved) VALUES ('$id', '$name', '$nickname', '$pwd', '$id_question', '$id_answer', '', '')";
$res = $conn->query($sql);
$sqlImg = "INSERT INTO profilepic (pic_num, id, status) VALUES (null, '$id', 0)";
$resImg = $conn->query($sqlImg);


$sql4 = "SELECT *FROM member WHERE id = '$id' AND nickname='$nickname'";
$res4 = $conn->query($sql4);

if($res4 -> num_rows > 0) {
echo "<script>alert('회원가입이 완료되었습니다.'); location.replace('/stdbhs/templ/login.php');</script>";
exit();
}  else {
echo "<script>alert('회원가입 양식을 다시 입력해 주세요.'); location.href='/stdbhs/templ/join.php'</script>";
exit();
}

 ?>
