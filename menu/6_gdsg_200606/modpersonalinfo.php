<?php require('lib/top.php');

// 세션있으면 페이지 접속가능
if($_SESSION['session_id']){
  if(isset($_POST['pwdReCheck'])){
    $pwdReCheck = $_POST['pwdReCheck'];


  $sessionID = $_SESSION['session_id'];

  $conn = new mysqli("localhost", "studybahasa", "bahasa", "StudyBahasa");
  mysqli_query($conn, 'SET NAMES utf8');

  $sql = "SELECT *FROM member WHERE id='$sessionID'";
  $res = $conn->query($sql);
  $row = mysqli_fetch_array($res);

  if($res -> num_rows > 0){
    $id = $row['id'];
  	$name = $row['name'];
  	$id_question = $row['id_question'];
    $id_answer = $row['id_answer'];
    $pwd = $row['pwd'];

  // @기준으로 이전문자 반환
  	$id1 = strstr($id, "@", true);
  	// @기준 이후 문자 반환
  	$id2 = strstr($id, "@");

    // 앞자리가 3글자 미만이면 뒤에서부터 2글자 치환
  	if(strlen($id1) <= 3){
  		$idPart = substr($id1, 0, -2)."**";
  		$idFinal = $idPart.$id2;
  	}else if(strlen($id1) < 4){
  		$idPart = substr($id1, 0, -3)."***";
  		$idFinal = $idPart.$id2;
  	}else{
  		// 뒤에서부터 4자리 문자 치환
  		$idPart = substr($id1, 0, -4)."****";
  		$idFinal = $idPart.$id2;
  	}

  // 유저 실명 길이를 구해서 3글자 이상이면 2글자를 보여주고 미만이면 1글자만 노출
  	$nameLength = mb_strlen($name, 'utf-8');
  	if($nameLength > 2){
  		$nameFinal = mb_substr($name, 0, 2, 'utf-8')."*";
  	}else{
  		$nameFinal = mb_substr($name, 0, 1, 'utf-8')."*";
  	}

  	if($pwd == $_POST['pwdReCheck']){

  ?>

  </section>
<center>
<section>
  <div style="padding:3em 45em 0em 0em; line-height:0.3;">
    <h3>개인정보 수정</h3><br>
    <p style="margin-left:245px;"><?php echo $_SESSION['session_name'];?>님의 개인 정보를 수정할 수 있습니다.</p>
  </div>
<form class="" action="" method="post">
  <div style="padding:3em 0em 2em 0em;">
    <table class="table table-bordered col-6">
    <tbody>
      <tr>
        <th scope="row" style="background:#f0f0f0; padding-top:30px; padding-left:20px;">이메일 아이디</th>
        <td style="padding:30px;">
          <p><?php echo $row['id'];?></p>
        </td>
      </tr>
      <tr>
        <th scope="row" style="background:#f0f0f0; padding-top:30px; padding-left:20px;">사용자 이름</th>
        <td style="padding:20px;">
          <input class="form-control col-6" type="text" name="name" value="<?php echo $row['name'];?>"maxlength="10" onkeyup="checkName(this.value)">
          <span id="nameCheckText"></span><br>
          <input type="hidden" id="nameHidden" name="nameHidden" value="1">
        </td>
      </tr>
      <tr>
        <th scope="row" style="background:#f0f0f0; padding-top:30px; padding-left:20px;">보안 질문</th>
        <td style="padding:20px;">
          <div class="form-group">
            <select class="form-control col-6" name="idQuestion" id="idQuestion" style="margin-bottom:20px;">
              <option value="나의 고향은?" <?php echo ($id_question == "나의 고향은?") ? 'selected' : ''; ?>>나의 고향은?</option>
              <option value="어머니의 성함은?" <?php echo ($id_question == "어머니의 성함은?") ? 'selected' : '';?>>어머니의 성함은?</option>
              <option value="아버지의 성함은?" <?php echo ($id_question == "아버지의 성함은?") ? 'selected' : '';?>>아버지의 성함은?</option>
              <option value="나의 보물 1호는?" <?php echo ($id_question == "나의 보물 1호는?") ? 'selected' : '';?>>나의 보물 1호는?</option>
              <option value="나의 반려동물의 이름은?" <?php echo ($id_question == "나의 반려동물의 이름은?") ? 'selected' : '';?>>나의 반려동물의 이름은?</option>
              <option value="내가 처음으로 가봤던 해외 여행지는?" <?php echo ($id_question == "내가 처음으로 가봤던 해외 여행지는?") ? 'selected' : '';?>>내가 처음으로 가봤던 해외 여행지는?</option>
              <option value="가장 기억에 남는 선생님의 성함은?" <?php echo ($id_question == "가장 기억에 남는 선생님의 성함은?") ? 'selected' : '';?>>가장 기억에 남는 선생님의 성함은?</option>
            </select>
            <input class="form-control col-6" type="text" name="idAnswer" id="idAnswer" value="<?= $id_answer;?>" maxlength="81" required>
          </div>
        </td>
      </tr>
      <tr>
        <th scope="row" style="background:#f0f0f0; padding-top:30px; padding-left:20px;">비밀번호</th>
        <td style="padding:20px;">
          <div class="form-group">
            <label>현재 비밀번호</label>
            <input class="form-control" type="password" name="pwdnow" id="PWDNOW" placeholder="영문, 숫자, 특수문자 6-15자." maxlength="15"><br>
            <!-- <span id="pwdCheckText"></span><br>
            <input type="hidden" id="pwdHidden" name="pwdHidden"> -->
          </div>
          <div class="form-group">
            <label>새 비밀번호</label>
            <input class="form-control" type="password" name="pwd" id="PWD" placeholder="영문, 숫자, 특수문자 6-15자." maxlength="15" onkeyup="checkPwd(this.value)"><br>
            <span id="pwdCheckText"></span><br>
            <input type="hidden" id="pwdHidden" name="pwdHidden">
          </div>

          <div class="form-group">
            <label>비밀번호 확인</label>
            <input class="form-control" type="password" name="pwdcheck" id="PWDCHECK" placeholder="비밀번호 확인" maxlength="15" onkeyup="checkPwd2(this.value)"><br>
            <span id="pwdCheckText2"></span><br>
          </div>
        </td>
      </tr>

    </tbody>
  </table>
  </div>
  <div style="margin-bottom:5em;">
    <button type="submit" class="btn btn-primary1" name="applyPersonalInfo">적용</button>
    <button class="btn btn-primary1">취소</button>
    <input type="hidden" name="pwdReCheck" value="<?= $pwdReCheck;?>">
  </div>
</form>
</section>
</center>

<?php
if(isset($_POST['applyPersonalInfo'])){
  // var_dump($_POST);
  $mod_name = $_POST['name'];
  $nameHidden = $_POST['nameHidden'];
  $mod_id_question = $_POST['idQuestion'];
  $mod_id_answer = $_POST['idAnswer'];
  $pwd_now = $_POST['pwdnow'];
  $mod_pwd = $_POST['pwd'];
  $mod_pwd_check = $_POST['pwdcheck'];
  $pwdHidden = $_POST['pwdHidden'];

  if($nameHidden != 1) {
  echo "<script>alert('이름을 다시 입력해 주세요.'); location.href='/stdbhs/templ/modpersonalinfo.php';</script>";
  exit();
  }

  if($pwd_now == ""){
    if($mod_pwd == "" && $mod_pwd_check == ""){
      $sqlMod1 = "UPDATE member SET name='$mod_name', id_question='$mod_id_question', id_answer='$mod_id_answer' WHERE id='$sessionID'";
      $resMod1 = $conn->query($sqlMod1);

      $sqlModCheck1 = "SELECT *FROM member WHERE id='$sessionID' AND name='$mod_name' AND id_question='$mod_id_question' AND id_answer='$mod_id_answer'";
      $resModCheck1 = $conn->query($sqlModCheck1);
      if($resModCheck1 -> num_rows > 0){
        echo "<script>alert('회원 정보가 수정되었습니다.'); location.replace('/stdbhs/templ/myaccount.php');</script>";
        exit();
      }else{
        echo "<script>alert('회원 정보를 다시 확인해 주세요.'); location.replace('/stdbhs/templ/myaccount.php');</script>";
        exit();
      }
    }else{
      echo "<script>alert('변경할 비밀번호를 입력해 주세요.'); location.href='/stdbhs/templ/modpersonalinfo.php';</script>";
      exit();
    }

  }

  if($pwd != $pwd_now){
    echo "<script>alert('변경 전 비밀번호가 일치하지 않습니다.'); location.href='/stdbhs/templ/modpersonalinfo.php';</script>";
  }

  if($pwdHidden != 1) {
  echo "<script>alert('비밀번호 제출 양식이 올바르지 않습니다.'); location.href='/stdbhs/templ/modpersonalinfo.php';</script>";
  exit();
  }

  $sqlMod2 = "UPDATE member SET name='$mod_name', id_question='$mod_id_question', id_answer='$mod_id_answer', pwd='$mod_pwd' WHERE id='$sessionID'";
  $resMod2 = $conn->query($sqlMod2);

  $sqlModCheck2 = "SELECT *FROM member WHERE id='$sessionID' AND name='$mod_name' AND id_question='$mod_id_question' AND id_answer='$mod_id_answer' AND pwd='$mod_pwd'";
  $resModCheck2 = $conn->query($sqlModCheck2);
  if($resModCheck2 -> num_rows > 0){
    echo "<script>alert('회원 정보가 수정되었습니다.'); location.replace('/stdbhs/templ/myaccount.php');</script>";
    exit();
  }else{
    echo "<script>alert('회원 정보를 다시 확인해 주세요.'); location.replace('/stdbhs/templ/myaccount.php');</script>";
    exit();
  }

}
 ?>

<script>

function checkName(name) { //checkName() 함수 실행 시작 부분
  // 정규식을 자음모음말고 가-힣으로 해놓으면 입력 잘 안됨..
  var nameRegExp = document.getElementById("NAME").value
    .replace(/[^ㄱ-ㅎㅏ-ㅣ가-힣]/g, "");
  document.getElementById("NAME").value = nameRegExp;
  var han = name.search(/[^가-힣]/g);

  if (nameRegExp.length >= 2) {
    //정규식 지킨 글자가 2자 이상일때 시작
    document.getElementById("nameCheckText").innerHTML = "";
    document.getElementById("nameHidden").value = "1";
  }else {
    document.getElementById("nameCheckText").innerHTML = "<font color=#c91d1d>실명을 입력해 주세요.</font>";
    document.getElementById("nameHidden").value = "";
  }
} //checkName() 함수 실행 끝 부분


function checkPwd(pwd) { //checkPwd(pwd) 함수 실행 시작 부분
  var pwdRegExp = document.getElementById("PWD").value
    .replace(/[^a-zA-Z0-9\~\`\!\@\#\$\%\^\&\*\(\)\_\-\+\=\{\}\[\]\|\\\:\;\"\'\<\>\,\.\?\/]/g, "");
  document.getElementById("PWD").value = pwdRegExp;
  var number = pwd.search(/[0-9]/g);
  var alphabet = pwd.search(/[a-z]/ig);
  var special =
    pwd.search(/[\~\`\!\@\#\$\%\^\&\*\(\)\_\-\+\=\{\}\[\]\|\\\:\;\"\'\<\>\,\.\?\/]/g);
  if (((alphabet >= 0) && (number >= 0) && (special >= 0)) &&
    (document.getElementById("PWD").value.length >= 6)) {
    //영어,숫자,특수문자를 포함하고 길이가 6이상일 때 실행 시작 부분
    if (document.getElementById("PWD").value == document.getElementById("pwdCheckText2").value) {
      //비밀번호 및 비밀번호 확인란의 값이 일치하는 경우 실행 시작 부분
      document.getElementById("pwdCheckText").innerHTML = "";
      document.getElementById("pwdCheckText2").innerHTML = "<font color=#6c9030>비밀번호가 확인되었습니다.</font>";
      document.getElementById("pwdHidden").value = "1";
    } //비밀번호 및 비밀번호 확인란의 값이 일치하는 경우 실행 끝 부분
    else { //비밀번호 및 비밀번호 확인란의 값이 일치하지 않는 경우 실행 시작 부분
      document.getElementById("pwdCheckText").innerHTML = "";
      document.getElementById("pwdCheckText2").innerHTML = "<font color=#c91d1d>비밀번호와 동일한 값을 입력해주세요.</font>";
      document.getElementById("pwdHidden").value = "";
    } //비밀번호 및 비밀번호 확인란의 값이 일치하지 않는 경우 실행 끝 부분
  } //영어,숫자,특수문자를 포함하고 길이가 6이상일 때 실행 끝 부분
  else {
    document.getElementById("pwdCheckText").innerHTML = "<font color=#c91d1d>영문, 숫자, 특수문자를 포함한  6자리 이상 입력하세요.</font>";
    document.getElementById("pwdCheckText2").innerHTML = "<font color=#c91d1d>비밀번호와 동일한 값을 입력해주세요.</font>";
    document.getElementById("pwdHidden").value = "";
  }
} //checkPwd(pwd) 함수 실행 끝 부분

function checkPwd2(pwd) { //checkPwd2(pwd) 함수 실행 시작 부분
  var pwdRegExp = document.getElementById("PWDCHECK").value
    .replace(/[^a-zA-Z0-9\~\`\!\@\#\$\%\^\&\*\(\)\_\-\+\=\{\}\[\]\|\\\:\;\"\'\<\>\,\.\?\/]/g, "");
  document.getElementById("PWDCHECK").value = pwdRegExp;
  var number = pwd.search(/[0-9]/g);
  var alphabet = pwd.search(/[a-z]/ig);
  var special =
    pwd.search(/[\~\`\!\@\#\$\%\^\&\*\(\)\_\-\+\=\{\}\[\]\|\\\:\;\"\'\<\>\,\.\?\/]/g);
  if (((alphabet >= 0) && (number >= 0) && (special >= 0)) &&
    (document.getElementById("PWDCHECK").value.length >= 6)) {
    //영어,숫자,특수문자를 포함하고 길이가 6이상일 때 실행 시작 부분
    if (document.getElementById("PWD").value == document.getElementById("PWDCHECK").value) {
      //비밀번호 및 비밀번호 확인란의 값이 일치하는 경우 실행 시작 부분
      document.getElementById("pwdCheckText").innerHTML = "";
      document.getElementById("pwdCheckText2").innerHTML = "<font color=#6c9030>비밀번호가 확인되었습니다.</font>";
      document.getElementById("pwdHidden").value = "1";
    } //비밀번호 및 비밀번호 확인란의 값이 일치하는 경우 실행 끝 부분
    else { //비밀번호 및 비밀번호 확인란의 값이 일치하지 않는 경우 실행 시작 부분
      document.getElementById("pwdCheckText2").innerHTML = "<font color=#c91d1d>비밀번호와 동일한 값을 입력해주세요.</font>";
      document.getElementById("pwdHidden").value = "";
    } //비밀번호 및 비밀번호 확인란의 값이 일치하지 않는 경우 실행 끝 부분
  } //영어,숫자,특수문자를 포함하고 길이가 6이상일 때 실행 끝 부분
  else {
    document.getElementById("pwdCheckText2").innerHTML = "<font color=#c91d1d>비밀번호와 동일한 값을 입력해주세요.</font>";
    document.getElementById("pwdHidden").value = "";
  }
} //checkPwd2(pwd) 함수 실행 끝 부분


</script>

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


<?php
// pwd == post['pwdReCheck'] 종료
        }else{
          echo "<script>alert('비밀번호를 다시 확인해 주세요.'); location.href='/stdbhs/templ/myaccount.php';</script>";
          exit();
        }

// sql문 종료
      }

// post['pwdReCheck'] 종료
   }

 }else { ?>
  <script> alert("로그인이 필요한 서비스 입니다.")
  location.replace('index.php')
  </script>
<?php } ?>

<?php require('lib/bottom.php'); ?>
