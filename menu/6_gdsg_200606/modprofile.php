<?php require('lib/top.php');

// 세션있으면 페이지 접속가능
if($_SESSION['session_id']){
  $id = $_SESSION['session_id'];
  $conn = new mysqli("localhost", "studybahasa", "bahasa", "StudyBahasa");
  mysqli_query($conn, 'SET NAMES utf8');
  $sql = "SELECT *FROM member WHERE id='$id'";
  $res = $conn->query($sql);
  $row = mysqli_fetch_array($res);

  if($res -> num_rows > 0){
  ?>

  </section>
<center>
<section>
  <div style="padding:3em 45em 0em 0em; line-height:0.3;">
    <h3>프로필 수정</h3><br>
    <p style="margin-left:245px;">블로그에서 보여지는 프로필과 별명을 수정할 수 있습니다.</p>
  </div>

<form class="" action="<?=$PHP_SELF?>" method="post">
  <div style="padding:3em 0em 2em 0em;">
    <table class="table table-bordered col-6">
    <tbody>
      <tr>
        <th scope="row" style="background:#f0f0f0; padding-top:30px; padding-left:20px;">프로필 사진</th>
        <td style="padding:30px;">

          <!-- 프로필사진 미리보기-->
            <div style="width:90px; height:90px; border-radius:50%; position:relative;" id="profilePic">

              <?php
                // status가 0인지 1인지 조회
                $sqlImg = "SELECT *FROM profilepic WHERE id='$id'";
                $resImg = mysqli_query($conn, $sqlImg);
                $rowImg = mysqli_fetch_assoc($resImg);

                if(!isset($_POST['profilepicsubmit'])){
                  // post로 받은 데이터가 없고 status가 0이면
                    if($rowImg['status'] == 0){
                     echo "<img style='border-radius:50%;' src='upload/user.png' height='90' width='90'>";
                   }else{
                     // post로 받은 데이터가 없지만 status가 1이라면
                     $sqlLoadPic = "SELECT *FROM member WHERE id='$id'";
                     $resLoadPic = mysqli_query($conn, $sqlLoadPic);
                     $rowLoadPic = mysqli_fetch_assoc($resLoadPic);
                     $loadedPic = $rowLoadPic['pic_name_saved'];
                     $loadedOriName = $rowLoadPic['pic_name_ori'];
                     echo "<img style='border-radius:50%;' src=".$loadedPic." height=90px; width=90px; alt='".$loadedOriName."'>";
                   }

                }else {
                  // post로 받은 데이터가 있으면
                    // 업로드할 경로
                    $uploadDir = 'upload/';
                    // 첨부될때의 원래 이름
                    $fileName = $_FILES['profilepic']['name'];
                    $fileError = $_FILES['profilepic']['error'];
                    $fileType = $_FILES['profilepic']['type'];
                    $fileExt = explode('.', $fileName);
                    // 파일 확장자 소문자로 변환
                    $fileActualExt = strtolower(end($fileExt));
                    $allowed = array('jpg', 'jpeg', 'png');
                    $time = date('Y-m-d-H-i-s');

                    if(in_array($fileActualExt, $allowed)){
                      if($fileError === 0){
                        $fileNameNew = "profile".$id."-".$time.".".$fileActualExt;
                        $uploadFile = $uploadDir.$fileNameNew;
                        // $uploadFile = $uploadDir.basename($_FILES['profilepic']['name']);
                        if(move_uploaded_file($_FILES['profilepic']['tmp_name'], $uploadFile)){
                          // echo "성공";
                          echo "<img style='border-radius:50%;' src=".$uploadFile." height=90px; width=90px; alt='".$fileName."'>";
                        }else {
                          print "실패";
                        }
                      }else {
                        echo "파일 안올라감!";
                      }
                    }else {
                      echo "이 형식의 파일은 업로드할 수 없습니다.";
                    }

                    $sqlProfilePic = "UPDATE member SET pic_name_ori='$fileName', pic_name_saved='$uploadFile' WHERE id='$id'";
                    $resProfilePic = $conn->query($sqlProfilePic);
                    $sqlStatus = "UPDATE profilepic SET status=1 WHERE id='$id'";
                    $resStatus = $conn->query($sqlStatus);
                }
                   ?>

                </div>
            </div>

            <div style="display: flex; margin-top:20px;">
              <button onclick="openUploadProfilePic()" class="btn btn-secondary" style="color:#fff; margin-right:10px;">사진변경</button>
              <!-- <a id="deletePic" class="btn btn-secondary" style="color:#fff;" onclick="updateProfilePicStatus()">삭제</a> -->
              <!-- <p id="responseText">sdf</p> -->

              <script>
               function openUploadProfilePic(){
                 window.open('uploadprofilepic.php','사진 변경', 'top=200, left=200, width=300px, height=300px, location=no, fullscreen=no, status=no, menubar=no, toolbar=no, resizable=no,')
               }

               // function updateProfilePicStatus(){
               //   // js로 sql문 작성해서 삭제 누르면 status를 다시 0으로 변경하고 새로고침
               //   // 삭제버튼값 가져오기
               //   var deletePic = document.getElementById("deletePic").value;
               //
               //   var request = new XMLHttpRequest();
               //   request.onreadystatechange = function(){
               //     if(request.readyState == 4 && request.status == 200){
               //       var responseText = document.getElementById("responseText");
               //       responseText.innerHTML = this.responseText;
               //     //   console.log("이상없음!");
               //     // }else {
               //     //   console.log("이상해!");
               //     }
               //   };
               //   request.open("post", "deleteProfilePic.php", true);
               //   request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
               //   request.send("deletePic=1");
               // }
              </script>


            </div>
        </td>
      </tr>
      <tr>
        <th scope="row" style="background:#f0f0f0; padding-top:30px; padding-left:20px;">별명</th>
        <td style="padding:20px;">

          <div style="display:flex;">
            <input class="form-control col-6" type="text" id="modNickName" value="<?php echo $row['nickname'];?>" required onkeyup="checkNickName()"maxlength="10" name="modNickName">
            <span style="margin-left:15px;"id="nickNameCheckText"></span><br>
          </div>
          <input type="hidden" id="nickNameHidden" name="nickNameHidden">
        </td>
      </tr>
    </tbody>
  </table>
  </div>
  <div style="margin-bottom:5em;">
      <button type="submit" class="btn btn-primary1" name="applyProfile">적용</button>
      <button class="btn btn-primary1">취소</button>
    </form>

    <?php
    $modNickName = $_POST['modNickName'];
    $nickNameHidden = $_POST['nickNameHidden'];

    // post로 받은 값이 있을때만
    if(isset($_POST['applyProfile'])){
      // global $fileName, $uploadFile;
      // $sqlProfilePic = "UPDATE member SET pic_name_ori='$fileName', pic_name_saved='$uploadFile' WHERE id='$id'";
      // $resProfilePic = $conn->query($sqlProfilePic);
      // $sqlStatus = "UPDATE profilepic SET status=1 WHERE id='$id'";
      // $resStatus = $conn->query($sqlStatus);

      // 닉네임양식체크
      // if($nickNameHidden == 1) {
      // $sql1 = "select *from member where id = '$id'";
      // $res1 = $conn->query($sql1);
      //   if($res1 -> num_rows > 0) {
      //    echo "<script>alert('이미 존재하는 닉네임입니다.'); location.href='/stdbhs/templ/modprofile.php'</script>";
      //    exit();
      //   }
      //  }else {
      //  echo "<script>alert('닉네임 양식이 올바르지 않습니다.'); location.href='/stdbhs/templ/modprofile.php'</script>";
      //  exit();
      // }
      // 해당하지 않으면 업데이트
      $sql1 = "UPDATE member SET nickname='$modNickName' WHERE id='$id'";
      $res1 = $conn->query($sql1);

      $sql2 = "SELECT *FROM member WHERE id = '$id' AND nickname='$modNickName'";
      $res2 = $conn->query($sql2);

      if($res2 -> num_rows > 0) {
        $_SESSION['session_name'] = $modNickName;
      echo "<script>alert('프로필이 수정되었습니다.'); location.replace('/stdbhs/templ/myaccount.php');</script>";
      exit();
      }  else {
      echo "<script>alert('이미 존재하는 닉네임입니다.'); location.href='/stdbhs/templ/modprofile.php'</script>";
      }

    }

     ?>


  </div>
</section>
</center>

<style>
.btn-primary1 {
  color: #fff;
  background-color: #9eb86d;
  border-color: #9eb86d;
}

.btn-primary1:hover {
  color: #fff;
  background-color: #c2d1a4;
  border-color: #c2d1a4;
}

.btn-primary11:focus, .btn-primary1.focus {
  color: #fff;
  background-color: #c2d1a4;
  border-color: #c2d1a4;
  box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
}

.btn-primary1.disabled, .btn-primary1:disabled {
  color: #fff;
  background-color: #c2d1a4;
  border-color: #c2d1a4;
}

.btn-primary1:not(:disabled):not(.disabled):active, .btn-primary1:not(:disabled):not(.disabled).active,
.show > .btn-primary1.dropdown-toggle {
  color: #fff;
  background-color: #779442;
  border-color: #779442;
}

.btn-primary1:not(:disabled):not(.disabled):active:focus, .btn-primary1:not(:disabled):not(.disabled).active:focus,
.show > .btn-primary1.dropdown-toggle:focus {
  box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
}
</style>

<!-- sql문 종료 -->
<?php } ?>

<?php }else { ?>
  <script> alert("로그인이 필요한 서비스 입니다.")
  location.replace('index.php')
  </script>
<?php } ?>

<?php require('lib/bottom.php'); ?>
<script>
function checkNickName() {
  var nickNameRegExp = document.getElementById("modNickName").value.replace(/[^a-zA-Z0-9ㄱ-ㅎㅏ-ㅣ가-힣]/g, "");
  //닉네임 입력 값에 a-z까지의 소문자, 알파벳 및 0-9까지의 숫자, _ 또는 - 특수문자를
  //제외한 값은 전부 공란으로 변경을 시켜서 변수 nameRegExp에 저장
  document.getElementById("modNickName").value = nickNameRegExp;
  //NICKNAME을 가진 닉네임 입력란의 값을 nickNameRegExp 저장된 값으로 교체

  if (nickNameRegExp.length >= 1) { //nickNameRegExp에 저장된 문자열 길이가 1이상일 때 실행 시작 부분

    var obj, dbParam, xmlhttp, myObj, x;
    //변수 obj, dbParam, xmlhttp, myObj, x 생성
    obj = {
      "table": "member",
      "nickname": nickNameRegExp
    };
    //변수 obj는 자바스크립트 객체 정보를 저장한다.
    dbParam = JSON.stringify(obj);
    //변수 dbParam은 obj에 담긴 자바스크립트 객체 정보를 JSON형식의 문자열로 저장한다.
    xmlhttp = new XMLHttpRequest();
    //변수 xmlhttp는 서버에 데이터를 요청한 값을 저장한다.
    xmlhttp.onreadystatechange = function() {
      //xmlhttpRequest 객체의 상태가 변할 때마다 자동으로 호출하는 함수 실행 시작 부분
      if (this.readyState == 4 && this.status == 200) {
        //데이터 전부를 받은 상태이고,
        //서버로부터의 응답상태가 요청 성공 상태라면 실행 시작 부분
        myObj = JSON.parse(this.responseText);
        //응답받은 JSON형식의 문자열을 자바스크립트 객체 값으로 myObj에 저장
        for (x in myObj) {
          //myObj에 저장된 자바스크립트 객체의 배열의 길이 값만큼 반복 실행 시작 부분
          if (myObj[x] == '1') { //myObj[x]에 담긴 값이 1이라면 실행 시작 부분
            document.getElementById("nickNameCheckText").innerHTML = "<font color=#c91d1d>이미 존재하는 닉네임 입니다.</font>";
            document.getElementById("nickNameHidden").value = "";
            //myObj[x]에 담긴 값이 1이라면 실행 끝 부분
          } else { //myObj[x]에 담긴 값이 1이 아니라면 실행 시작 부분
            document.getElementById("nickNameCheckText").innerHTML = "<font color=#6c9030>사용 가능한 닉네임 입니다.</font>";
            document.getElementById("nickNameHidden").value = "1";
          } //myObj[x]에 담긴 값이 1이 아니라면 실행 끝 부분
        } //myObj에 저장된 자바스크립트 객체의 배열의 길이 값만큼 반복 실행 끝 부분
      }
      //데이터 전부를 받은 상태이고,
      //서버로부터의 응답상태가 요청 성공 상태라면 실행 끝 부분
    }; //xmlhttpRequest 객체의 상태가 변할 때마다 자동으로 호출하는 함수 실행 끝 부분
    xmlhttp.open("POST", "userNickNameCheck.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("content=" + dbParam);

    //nickNameRegExp에 저장된 문자열 길이가 1이상일 때 실행 끝 부분
  } else { //nickNameRegExp에 저장된 문자열 길이가 1 미만일 때 실행 시작 부분
    document.getElementById("nickNameCheckText").innerHTML = "<font color=#c91d1d>특수문자는 사용할 수 없습니다.</font>";
    document.getElementById("nickNameHidden").value = "";
  } //nickNameRegExp에 저장된 문자열 길이가 1 미만일 때 실행 끝 부분

} //checkNickName() 함수 실행 끝 부분
</script>
