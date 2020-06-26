<?php
header("Content-Type: text/html; charset=UTF-8");
$conn = new mysqli("localhost", "studybahasa", "bahasa", "StudyBahasa");
mysqli_query($conn, 'SET NAMES utf8');

$name = $_POST['name'];
$id_question = $_POST['idQuestion'];
$id_answer = $_POST['idAnswer'];

$sql = "select *from member where name = '$name' and id_question = '$id_question' and id_answer = '$id_answer'";
$res = $conn->query($sql);
$row = mysqli_fetch_array($res);

$id = $row['id'];
// @기준으로 이전문자 반환
  $id1 = strstr($id, "@", true);
  // @기준 이후 문자 반환
  $id2 = strstr($id, "@");

if($res->num_rows > 0){
  if(strlen($id1) <= 3){
    $idPart = substr($id1, 0, -2)."**";
    $idFinal = $idPart.$id2;
    echo "<script>alert('회원님의 아이디는 $idFinal 입니다')</script>";
    echo "<script>window.close();</script>";
  }else if(strlen($id1) < 4){
    $idPart = substr($id1, 0, -3)."***";
    $idFinal = $idPart.$id2;
    echo "<script>alert('회원님의 아이디는 $idFinal 입니다')</script>";echo "<script>window.close();</script>";
  }else{
    $idPart = substr($id1, 0, -4)."****";
    $idFinal = $idPart.$id2;
    echo "<script>alert('회원님의 아이디는 $idFinal 입니다')</script>";
    echo "<script>window.close();</script>";
  }

}else {
   echo "<script>alert('회원 정보가 없습니다.')</script>";
   echo "<script>location.href='/stdbhs/templ/findID.html'</script>";
}

 ?>
