<?php
header("Pragma:no-cache");
header("Cache-Control:no-cache, must-revalidate");
 ?>
<!DOCTYPE html>
<html lang="kr">

<head>
  <meta charset="utf-8">
  <title>회원가입</title>
  <link rel="stylesheet" href="/stdbhs/bootstrap-4.4.1-dist/css/bootstrap.css">
</head>

<body>

  <div class="container h-100">
    <div class="row h-100">
      <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
        <div class="d-table-cell align-middle">

          <div class="text-center mt-4">
            <h1 class="h2">회원가입</h1>
            <p class="lead">
              Join us to start the best learning experience of your life!
            </p>
          </div>

          <div class="card">
            <div class="card-body">
              <div class="m-sm-4">
                <form action="/stdbhs/templ/joinresult.php" method="post" onsubmit="return checkData()">

                  <div class="form-group">
                    <label>Email</label>
                    <input class="form-control form-control-lg" type="email" name="id" id="EMAIL" placeholder="실제 사용하는 이메일 주소를 작성해주세요." onkeyup="checkId()"><br>
                    <span id="emailCheckText"></span><br>
                    <input type="hidden" id="emailHidden">
                  </div>

                  <div style="display:flex; margin-bottom:10px;" id="valBtnDiv" name="valBtnDiv">
                    <div name="valCodeDiv" id="valCodeDiv" style="visibility: hidden;">
                      <input style="width:300px;"type="text" placeholder="인증코드를 입력하세요" id="codeText">
                      <button type="button" class="btn btn-sm btn-primary" value="확인" id="confirmValCode" onclick="submitValCode(this.form)">확인</button>
                    </div>
                    <input type="hidden" id="confirmValCodeHidden" name="confirmValCodeHidden">
                    <div id="confirmValCodeMsg" style="visibility:hidden;">
                      <span id="confirmValCodeText" name="confirmValCodeText"></span>
                    </div>

                      <button style="position:absolute; right:20px;" type="button" class="btn btn-sm btn-primary" value="이메일 인증" id="validateEmail" disabled onclick="return validateConfirm(this.form);">이메일 인증</button>
                  </div>

                  <script>
                  var email = document.getElementById("EMAIL").value;
                  var randomStr, codeText, strValCode;

                  var getCookie = function(name){
                    var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
                  // 삼항연산자 value가 있다면 value[2](2가 뭐야)를 리턴하고 아니면 null리턴
                    return value? value[2] : null;
                  };

                    function validateConfirm(form1){
                      // 인증코드 입력창 visible로 전환
                      var validateEmail = document.getElementById("validateEmail");
                      validateEmail.style.visibility = 'hidden';
                      var valCodeDiv = document.getElementById("valCodeDiv");
                      valCodeDiv.style.visibility = 'visible';

                      // 쿠키생성 함수
                        function setCookie(name, value, exp){
                          var date = new Date();
                          date.setTime(date.getTime() + exp*60*1000);
                          document.cookie = name + "=" + value + ';expires=' + date.toUTCString() + ';path=/';
                        };
                        //쿠키이름, 내용, 시간
                        setCookie("valCodeExist", "1", 1);
                        console.log(getCookie("valCodeExist"));

                      // ajax http request
                      var xhr = new XMLHttpRequest();
                      xhr.open('post', './sendValEmail.php', true);
                      xhr.onreadystatechange = function(){
                        if(xhr.readyState === 4 && xhr.status === 200){
                          // console.log(xhr.responseText);
                          var strArray = xhr.responseText.split('.');
                          var strAlert = strArray[0];
                          strValCode = strArray[1];
                          // console.log(strAlert);
                          console.log(strValCode);
                          alert(strAlert+".");

                        }
                      }
                      randomStr = Math.random().toString(36).substring(2, 10);
                      var data = '';
                      // =앞에 있는 이름이 전송후에 $_POST['이름'] 으로 사용
                      data += 'id=' + document.getElementById('EMAIL').value;
                      data += '&emailValCode=' + randomStr;
                      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                      xhr.send(data);
                      return true;
                    }

                    function submitValCode(form2){
                      codeText = document.getElementById("codeText").value;
                      var confirmValCode = document.getElementById("confirmValCode");
                      var confirmValCodeMsg = document.getElementById("confirmValCodeMsg");


                      // ajax http request
                      var xhr = new XMLHttpRequest();
                      xhr.open("post", "./confirmValCode.php", true);
                      xhr.onreadystatechange = function(){
                        if(xhr.readyState === 4 && xhr.status === 200){
                          if(getCookie("valCodeExist")){
                            if(xhr.responseText != "인증 코드가 일치하지 않습니다."){
                              valCodeDiv.style.display = 'none';
                              confirmValCodeMsg.style.visibility = 'visible';
                              document.getElementById("confirmValCodeText").innerHTML = xhr.responseText;
                              document.getElementById("confirmValCodeHidden").value = "1";
                              console.log(document.getElementById("confirmValCodeHidden").value);

                            }else{
                              confirmValCodeMsg.style.visibility = 'visible';
                              document.getElementById("confirmValCodeHidden").value = "";
                              document.getElementById("codeText").value = "";
                              alert(xhr.responseText);
                            }

                          }else {
                            alert(xhr.responseText);
                            document.getElementById("validateEmail").style.visibility = 'visible';
                            confirmValCodeMsg.style.visibility = 'hidden';
                            document.getElementById("valCodeDiv").style.visibility = 'hidden';
                            document.getElementById("confirmValCodeHidden").value = "";
                            document.getElementById("codeText").value = "";
                          }

                        }
                      }
                      var data1 = '';
                      data1 += 'codeText=' + codeText;
                      data1 += '&valCode=' +strValCode;
                      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                      xhr.send(data1);
                      return true;
                    }


                  </script>



                  <div class="form-group">
                    <label>Name</label>
                    <input class="form-control form-control-lg" type="text" name="name" id="NAME" placeholder="실명. 한글." maxlength="10" onkeyup="checkName(this.value)"><br>
                    <span id="nameCheckText"></span><br>
                    <input type="hidden" id="nameHidden" name="nameHidden">
                  </div>

                  <div class="form-group">
                    <label>Nickname</label>
                    <input class="form-control form-control-lg" type="text" name="nickname" id="NICKNAME" placeholder="한, 영, 숫자 10자 미만." maxlength="10" onkeyup="checkNickName()"><br>
                    <span id="nickNameCheckText"></span><br>
                    <input type="hidden" id="nickNameHidden" name="nickNameHidden">
                  </div>

                  <!-- <div class="form-group">
                    <label>Phone Number</label>
                    <input class="form-control form-control-lg" type="text" name="phonenum" id="PHONENUM" placeholder="휴대전화 번호" maxlength="11" onkeyup="checkPhoneNum(this.value)"><br>
                    <span id="phoneNumCheckText"></span><br>
                    <input type="hidden" id="phoneNumHidden" name="phoneNumHidden">
                  </div> -->

                  <div class="form-group">
                    <label>Password</label>
                    <input class="form-control form-control-lg" type="password" name="pwd" id="PWD" placeholder="영문, 숫자, 특수문자 6-15자." maxlength="15" onkeyup="checkPwd(this.value)"><br>
                    <span id="pwdCheckText"></span><br>
                    <input type="hidden" id="pwdHidden" name="pwdHidden">
                  </div>

                  <div class="form-group">
                    <label>Check Password</label>
                    <input class="form-control form-control-lg" type="password" name="pwdcheck" id="PWDCHECK" placeholder="비밀번호 확인" maxlength="15" onkeyup="checkPwd2(this.value)"><br>
                    <span id="pwdCheckText2"></span><br>
                  </div>

                  <div class="form-group" style="margin-bottom:50px;">
                    <label>보안 질문</label>
                    <select class="form-control form-control-lg" name="idQuestion" id="idQuestion" style="margin-bottom:20px;">
                      <option value="나의 고향은?">나의 고향은?</option>
                      <option value="어머니의 성함은?">어머니의 성함은?</option>
                      <option value="아버지의 성함은?">아버지의 성함은?</option>
                      <option value="나의 보물 1호는?">나의 보물 1호는?</option>
                      <option value="나의 반려동물의 이름은?">나의 반려동물의 이름은?</option>
                      <option value="내가 처음으로 가봤던 해외 여행지는?">내가 처음으로 가봤던 해외 여행지는?</option>
                      <option value="가장 기억에 남는 선생님의 성함은?">가장 기억에 남는 선생님의 성함은?</option>
                    </select>
                    <input class="form-control form-control-lg" type="text" name="idAnswer" id="idAnswer" placeholder="아이디를 찾을 때 필요한 질문입니다." maxlength="81" required>
                  </div>

                  <div class="text-center mt-3">
                    <input type="submit" class="btn btn-lg btn-primary" value="회원가입">
                    <a href="index.php" class="btn btn-lg btn-primary">돌아가기</a>
                  </div>

                </form>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script>
  function checkData(){
    return true;
  }
    function checkId() {
      // g,""=값이 맞는지 확인하고 아닐경우 ""빈칸으로 바꿔준다
      // var idRegExp = document.getElementById("EMAIL").value.replace(/^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/g, "");
      // document.getElementById("EMAIL").value = idRegExp;
      var idRegExp = document.getElementById("EMAIL").value;


      // json형식으로 저장하기위한 단계
      var obj, dbParam, xmlhttp, myObj, x;
      obj = {
        "table": "member",
        "id": idRegExp
      };
      // obj에 js객체로 저장한것을 json형식으로 문자열을 담는다
      dbParam = JSON.stringify(obj);
      xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // 응답받은 json형식의 문자를 js객체로 바꿔서 myObj변수에 저장
          myObj = JSON.parse(this.responseText);
          // myObj에 저장된 js객체 배열의 길이만큼 반복문을 실행
          for (x in myObj) {

            var validateEmail = document.getElementById("validateEmail");
            if (myObj[x] == '1') {
              document.getElementById("emailCheckText").innerHTML = "<font color=#c91d1d>이미 존재하는 이메일 입니다.</font>";
              document.getElementById("emailHidden").value = "";
              validateEmail.disabled = true;

            } else {
              document.getElementById("emailCheckText").innerHTML = "<font color=#6c9030>사용 가능한 이메일 입니다.</font>";
              document.getElementById("emailHidden").value = "1";
              validateEmail.disabled = false;
            }
          }
        }
      };
      // db를 사용할수 있게 하는 공식
      xmlhttp.open("POST", "userIdCheck.php", true);
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send("content=" + dbParam);
    }



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



    function checkNickName() {
      var nickNameRegExp = document.getElementById("NICKNAME").value.replace(/[^a-zA-Z0-9ㄱ-ㅎㅏ-ㅣ가-힣]/g, "");
      //닉네임 입력 값에 a-z까지의 소문자, 알파벳 및 0-9까지의 숫자, _ 또는 - 특수문자를
      //제외한 값은 전부 공란으로 변경을 시켜서 변수 nameRegExp에 저장
      document.getElementById("NICKNAME").value = nickNameRegExp;
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


    // function checkPhoneNum(num) { //checkPhoneNum() 함수 실행 시작 부분
    //   var phoneRegExp = document.getElementById("PHONENUM").value
    //     .replace(/[^0-9]/g, "");
    //   document.getElementById("PHONENUM").value = phoneRegExp;
    //   var number = num.search(/[0-9]/g);
    //
    //   if ((number >= 0) && (document.getElementById("PHONENUM").value.length >= 10)) {
    //     //숫자를 포함하고 길이가 10이상일 때 실행 시작 부분
    //     document.getElementById("phoneNumCheckText").innerHTML = "";
    //     document.getElementById("phonenumHidden").value = "1";
    //   }else {
    //     document.getElementById("phoneNumCheckText").innerHTML = "<font color=#c91d1d>휴대전화 번호를 10자리 이상 입력하세요.</font>";
    //     document.getElementById("phonenumHidden").value = "";
    //   }
    // } //checkPhoneNum() 함수 실행 끝 부분


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

  <!-- <script type="text/javascript">
  function checkData(){
    if(!checkId(form.id.value)){
      return false;
    }
    if(!checkName(form.name.value)){
      return false;
    }
    if(!checkPassword(form.id.value, form.pwd.value, form.pwdcheck.value)){
      return false;
    }
    return true;
  }

// 공백체크함수
  function checkDataExist(value, dataName){
    if(value == ""){
      alert(dataName + "입력해 주세요.");
      return false;
    }
    return true;
  }

// 아이디체크 함수
  function checkId(id){
    // 아이디가 입력되었는지 확인
    if(!checkDataExist(id, "아이디를"))
    return false;

    // 이메일 유효성검사
    var idRegExp = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
    if(!idRegExp.test(id)){
      alert("이메일 형식이 올바르지 않습니다.")
      // 폼에 입력된 값을 공백으로 초기화 하고 포커스를 맞춘다
      form.id.value = "";
      form.id.focus();
      return false;
    }
    // 확인이 완료되었을 때
    return true;
  }

  function checkPassword(id, pwd, pwdcheck){
    // 비밀번호가 입력되었는지 확인
    if(!checkDataExist(pwd, "비밀번호를")){
      return false;
    }
    // 비밀번호 확인이 입력되었는지 확인
    if(!checkDataExist(pwdcheck, "비밀번호 확인을")){
      return false;
    }

    // 비밀번호 유효성검사
    var pwdRegExp = /^[a-zA-z0-9]{6,15}$/;
    if(!pwdRegExp.test(pwd)){
      alert("비밀번호는 영문 대소문자와 숫자 6-15자리로 입력해야 합니다.");
      form.pwd.value = "";
      form.pwd.focus();
      return false;
    }
    // 비밀번호와 비밀번호 확인이 일치하지 않으면
    if(pwd != pwdcheck){
      alert("비밀번호 확인이 일치하지 않습니다.");
      form.pwdcheck.value = "";
      form.pwdcheck.focus();
      return false;
    }
  // 확인 완료
    return true;
  }

  // 이름 검사 함수
  function checkName(name){
    if(!checkDataExist(name, "이름을")){
      return false;

      var nameRegExp = /^[가-힣]{2,4}$/;
      if(!nameRegExp.test(name)){
        alert("이름이 올바르지 않습니다.");
        return false;
      }
      return true;
    }

  }

  </script> -->




</body>

</html>
