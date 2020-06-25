<?php
require '/var/www/html/menu/db.php';
error_reporting(E_ALL);
ini_set("display_errors", 1);

// js console.log를 php로 옮김
function console_log($data){
    echo "<script>console.log('PHP_CONSOLE : ".$data."');</script>";
  }

$id = $_POST['id'];
$email = $_POST['email'];
$pwd = $_POST['pwd1'];
if(empty($_POST['birthYear'])){
    $birthYear = '0';
}else{
    $birthYear = $_POST['birthYear'];
}
if(empty($_POST['gender'])){
    $gender = '0';
}else{
    $gender = $_POST['gender'];
}

//값들이 1일때 제대로 전달된것
$idHidden = $_POST['idHidden'];
$emailHidden = $_POST['emailHidden'];
$pwd1Hidden = $_POST['pwd1Hidden'];
$pwd2Hidden = $_POST['pwd2Hidden'];
$birthYearHidden = $_POST['birthYearHidden'];


if($idHidden != 1) {
    echo "<script>alert('아이디를 다시 입력해 주세요.'); location.href='signup.php';</script>";
    exit();
}else if($emailHidden != 1) {
    echo "<script>alert('이메일을 다시 입력해 주세요.'); location.href='signup.php';</script>";
    exit();
}else if($pwd1Hidden != 1 || $pwd2Hidden != 1) {
    echo "<script>alert('비밀번호를 다시 입력해 주세요.'); location.href='signup.php';</script>";
    exit();
// }else if($birthYearHidden != 1) {
//     echo "<script>alert('출생년도를 다시 입력해 주세요.'); location.href='signup.php';</script>";
//     exit();
}else{

// 전송체크
console_log($id);
console_log($email);
console_log($pwd);
console_log($birthYear);
console_log($gender);

console_log($idHidden);
console_log($emailHidden);
console_log($pwd1Hidden);
console_log($pwd2Hidden);
console_log($birthYearHidden);

$sql = queryResult("INSERT INTO user (id, email, pwd, birthyear, gender, pic_name_ori, pic_name_saved) 
                    VALUES ('$id', '$email', '$pwd', '$birthYear', '$gender', '', '')");
echo "<script>alert('회원가입이 완료되었습니다.'); location.replace('login.php');</script>";
exit();
}




?>