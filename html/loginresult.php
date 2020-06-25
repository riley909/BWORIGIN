<?php
require '/var/www/html/menu/db.php';

// post로 받은 내용을 변수에 저장
$id = $_POST['id'];
$pwd = $_POST['pwd'];
$rememberid = $_POST['rememberid'];

// db에서 해당 아이디 찾기
$sql = queryResult("SELECT *FROM user WHERE id = '$id' AND pwd = '$pwd'");
$row = $sql->fetch_array();
if($sql->num_rows > 0){
  // db에 있을 경우 세션 생성
  $_SESSION['session_id'] = $id;
  if(isset($_SESSION['session_id'])){

// 세션이 생기고 로그인이 유효하면
// post로 넘어온 체크박스에 값이 있으면(체크가 되어있으면) 쿠키생성
    if(isset($rememberid)){
      setcookie('savedid', $id, time()+60);
      setcookie('checked', $rememberid, time()+60);
    }

    // 세션이 생겼을 경우 메인페이지로 이동
    echo "<script>location.href='index.php';</script>";
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
