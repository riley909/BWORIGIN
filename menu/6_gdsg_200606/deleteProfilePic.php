<?php
if(isset($_SESSION['session_id'])){
  // js로 삭제버튼을 post로 보내고 받은 값이 있으면 db update

  foreach($_POST as $post_var){
    echo strtoupper($post_var);
  }
  // if(isset($_POST['deletePic'])){
  //   echo "바뀐다!";
  //   $sqlDelete = "UPDATE profilepic SET status=0 WHERE id='$id'";
  // }else{
  //   echo "안돼!";
  // }
}

?>
