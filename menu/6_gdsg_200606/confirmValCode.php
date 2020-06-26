<?php
if(isset($_POST)){
  $codeText = $_POST['codeText'];
  $valCode = $_POST['valCode'];
  // echo $codeText;
  // echo $valCode;

  // 쿠키가 유효하면
if(isset($_COOKIE['valCodeExist'])){
  if($codeText == $valCode){
    echo "<font color=#6c9030>인증 완료되었습니다.</font>";
  }else{
    echo "인증 코드가 일치하지 않습니다.";
  }
}else{
  echo "인증 코드 유효 시간이 초과되었습니다.";
}

}
 ?>
