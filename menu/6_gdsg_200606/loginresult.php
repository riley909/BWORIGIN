<?php
header("Content-Type: text/html; charset=UTF-8");
session_start();
$conn = new mysqli("localhost", "studybahasa", "bahasa", "StudyBahasa");
mysqli_query($conn, 'SET NAMES utf8');

// post로 받은 내용을 변수에 저장
$id = $_POST['id'];
$pwd = $_POST['pwd'];
$id_check = $_POST['id_check'];

// db에서 해당 아이디 찾기
$sql = "select *from member where id = '$id' and pwd = '$pwd'";
$res = $conn->query($sql);
$row = mysqli_fetch_array($res);

if($res -> num_rows > 0){
  // db에 있을 경우 세션 생성
  $_SESSION['session_id'] = $id;
  $_SESSION['session_name'] = $row["nickname"];
  if(isset($_SESSION['session_id']) && isset($_SESSION['session_name'])){

// 세션이 생기고 로그인이 유효하면
// post로 넘어온 체크박스에 값이 있으면(체크가 되어있으면) 쿠키생성
    if(isset($id_check)){
      setcookie('saveid', $id, time()+60);
      setcookie('checked', $id_check, time()+60);
    }

    // 세션이 생겼을 경우 메인페이지로 이동
    echo "<script>location.href='/stdbhs/templ/index.php';</script>";
  }else{ ?>

  <script>
  alert('아이디와 비밀번호를 확인하세요.');
  history.back();
  </script>

  <?php
  }

}else { ?>

<script>
alert('아이디와 비밀번호를 확인하세요.');
history.back();
</script>

<?php } ?>
