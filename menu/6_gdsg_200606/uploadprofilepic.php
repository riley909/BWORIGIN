<?php
header("Content-Type: text/html; charset=UTF-8");
session_start();

if(isset($_SESSION['session_id'])){ ?>

<!DOCTYPE html>
<html lang="kr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>사진 변경</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </head>
  <body>

    <!-- 팝업창에서 부모창으로 submit을 주고 싶을때는 target을 설정한다. form데이터가 target으로 이동하면서 페이지 액션이 일어나고 self.close()를 사용하면 팝업창은 스스로 닫힌다 -->
    <form action="modprofile.php" method="post" id="popupFormId" name="popupForm" enctype="multipart/form-data">
      <label>uploading files</label>
      <p><input type="file" name="profilepic"></p>
      <p><button type="submit" id="profilepicsubmit" name="profilepicsubmit" onclick="closeUploadProfilePic()">전송</button></p>
    </form>

    <script>
    // var popupFormId = document.getElementById("popupFormId");
    // var profilepicsubmit = document.getElementById("profilepicsubmit");
    //   popupFormId.addEventListener('submit', function(event) {
    //     // 이벤트를 취소할 수 있는 경우(취소불가능한경우도 있음) 이벤트를 취소하는 함수.
    //     // 밑에 submit함수를 호출하니까 미친듯이 submit됨..
    //     event.preventDefault();
    //     console.log(event);
    //     // ajax로 send하는 부분
    //     var request = new XMLHttpRequest();
    //     request.open("post", "test.php");
    //     request.onload = function(){
    //       console.log(request.responseText);
    //     }
    //     request.send(new FormData(popupFormId));
    //   });

    function closeUploadProfilePic(){
      // 폼의 name으로 변수를 선언
      var formName = document.forms.popupForm;
      // 창을 연 부모창의 이름을 설정. 유니크한 이름이어야한다.
      opener.name = "modprofilePage";
      // 폼의 타겟을 부모창의 이름으로 지정
      formName.target = opener.name;
      formName.submit();
      self.close();
    }



    </script>

  </body>
  </html>

<?php }else{ ?>

<script>
 alert("로그인이 필요한 서비스 입니다.")
 location.replace('index.php')
</script>

<?php } ?>
