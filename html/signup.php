<!doctype html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
        integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600|Open+Sans:400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="../css/easion.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
    <script src="../js/chart-js-config.js"></script>

    <!-- include libraries(jQuery, bootstrap) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <title>Binge Watch</title>
</head>

<body>
    <div class="form-screen">
        <a href="index.php" class="easion-logo"><i class="fas fa-cookie-bite"></i> <span>Binge Watch</span></a>
        <div class="card account-dialog">
            <div class="card-header bg-secondary text-white"> 회원 가입 </div>
            <div class="card-body">
            
                <form method="post" action="signupresult.php">
                    <!-- 아이디 -->
                    <div class="form-group">
                        <input type="text" class="form-control" id="id" name="id" placeholder="아이디" onkeyup="idcheck()">
                        <span class="text-danger" id="idCheckText" style="font-size:0.8em;"></span>
                        <input type="hidden" id="idHidden" name="idHidden">
                    </div>

                    <!-- 이메일 -->
                    <!-- TODO: 이메일 인증절차 -->
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="이메일"
                            onkeyup="emailcheck()">
                            <span class="text-danger" id="emailCheckText" style="font-size:0.8em;"></span>
                        <input type="hidden" id="emailHidden" name="emailHidden">
                    </div>

                    <!-- 비번 -->
                    <div class="form-group">
                        <input type="password" class="form-control" id="pwd1" name="pwd1" placeholder="비밀번호" onkeyup="pwd1check(this.value)">
                        <input type="password" class="form-control" id="pwd2" placeholder="비밀번호 확인" onkeyup="pwd2check(this.value)">
                        <span class="text-danger" id="pwdCheckText" style="font-size:0.8em;"></span>
                        <input type="hidden" id="pwd1Hidden" name="pwd1Hidden">
                        <input type="hidden" id="pwd2Hidden" name="pwd2Hidden">
                    </div>
                    <div>
                        <p class="text-secondary" style="font-size:0.9em; margin-bottom:5px;">선택 입력</p>
                        <div style="display:flex;">
                        <div class="form-group">
                            <input type="text" class="form-control" id="birthYear" name="birthYear" placeholder="출생년도"
                                onkeyup="birthyearcheck()" style="width:95%; flex:1;" maxlength="4"> 
                            <input type="hidden" id="birthYearHidden" name="birthYearHidden">
                        </div>

                        <!-- TODO: 라디오버튼 체크해제 -->
                        <div class="btn-group btn-group-toggle" data-toggle="buttons" style="flex:1; margin-bottom: 1rem; margin-left:0;">
                            <label class="btn btn-outline-secondary" style="width:65px; border-color:#c9c9c9;">
                                <input type="radio" name="gender" id="male" value="1"> 남
                            </label>
                            <label class="btn btn-outline-secondary" style="width:65px; border-color:#c9c9c9;">
                                <input type="radio" name="gender" id="female" value="2"> 여
                            </label>
                        </div>
                        </div>
                         <!-- 출생년도 경고문 -->
                        <span class="text-danger" id="birthYearCheckText" style="font-size:0.8em;"></span>
                    </div>
                    <div class="account-dialog-actions">
                        <button type="submit" class="btn btn-info mb-4" id="btn_signup" style="width:100%; height:40px; margin-top:10px;">회원 가입 완료</button>
                    </div>
                    <a class="account-dialog-link" href="login.php" style="margin-left:190px;">이미 계정이 있나요?</a>
                </form>
            </div>
        </div>
    </div>

    <script>

        //아이디체크
        function idcheck() {
            var idReg = /^[a-z]+[a-z0-9]{4,19}$/g;
            var id = document.getElementById("id").value;
            var idc = idReg.test(id);

            //공백확인
            if(id == ""){
                document.getElementById("idCheckText").innerHTML = "아이디를 입력해 주세요.";
                document.getElementById("idHidden").value = "";
            //정규식검사
            }else if(idc == false){
                document.getElementById("idCheckText").innerHTML = "5-20자의 영문 소문자와 숫자로만 입력해 주세요.";
                document.getElementById("idHidden").value = ""; 
            
            //정규식 통과하면
            }else if(idc == true){
                // json형식으로 저장하기위한 단계
                var obj, dbParam, xmlhttp, myObj, x;
                obj = {
                    "table": "user",
                    "id": id
                };

                // obj에 js객체로 저장한것을 json형식으로 문자열을 담는다
                dbParam = JSON.stringify(obj);
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        // 응답받은 json형식의 문자를 js객체로 바꿔서 myObj변수에 저장
                        myObj = JSON.parse(this.responseText);
                        // myObj에 저장된 js객체 배열의 길이만큼 반복문을 실행
                        for(x in myObj){
                            if(myObj[x] == '1'){
                                document.getElementById("idCheckText").innerHTML = "이미 존재하는 아이디 입니다.";
                                document.getElementById("idHidden").value = "";
                            }else{
                                document.getElementById("idCheckText").innerHTML = "";
                                document.getElementById("idHidden").value = "1"; 
                            }
                        }
                    }
                };

                // db를 사용할수 있게 하는 공식
                xmlhttp.open("POST", "userIdCheck.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("content=" + dbParam);
                //dbParam의 값을 content에 담아서 userIdcheck.php에 Post형식으로 전달

            }else{
                document.getElementById("idCheckText").innerHTML = "";
            }
        }

//이메일체크
        function emailcheck() {
            var emailReg = /^[A-Za-z0-9_]+[A-Za-z0-9]*[@]{1}[A-Za-z0-9]+[A-Za-z0-9]*[.]{1}[A-Za-z]{1,3}$/;
            var email = document.getElementById("email").value;
            var emailc = emailReg.test(email);

            //공백확인
            if(email == ""){
                document.getElementById("emailCheckText").innerHTML = "이메일을 입력해 주세요.";
                document.getElementById("emailHidden").value = "";
            //정규식검사
            }else if(emailc == false){
                document.getElementById("emailCheckText").innerHTML = "유효한 이메일 주소가 아닙니다.";
                document.getElementById("emailHidden").value = ""; 
            
            //정규식 통과하면
            }else if(emailc == true){
                // json형식으로 저장하기위한 단계
                var obj, dbParam, xmlhttp, myObj, x;
                obj = {
                    "table": "user",
                    "email": email
                };

                // obj에 js객체로 저장한것을 json형식으로 문자열을 담는다
                dbParam = JSON.stringify(obj);
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        // 응답받은 json형식의 문자를 js객체로 바꿔서 myObj변수에 저장
                        myObj = JSON.parse(this.responseText);
                        // myObj에 저장된 js객체 배열의 길이만큼 반복문을 실행
                        for(x in myObj){
                            if(myObj[x] == '1'){
                                document.getElementById("emailCheckText").innerHTML = "이미 존재하는 이메일 입니다.";
                                document.getElementById("emailHidden").value = ""; 
                            }else{
                                document.getElementById("emailCheckText").innerHTML = "";
                                document.getElementById("emailHidden").value = "1";   
                            }
                        }
                    }
                };

                // db를 사용할수 있게 하는 공식
                xmlhttp.open("POST", "userEmailCheck.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("content=" + dbParam);
                //dbParam의 값을 content에 담아서 userEmailcheck.php에 Post형식으로 전달

            }else{
                document.getElementById("emailCheckText").innerHTML = "";
                document.getElementById("emailHidden").value = "1"; 
            }
        }


        //비번1체크
        function pwd1check(pwd){
            var pwdReg = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*\W).{6,20}$/g;
            var pwd1 = document.getElementById("pwd1").value;
            var pwd1c = pwdReg.test(pwd1);

            //공백확인
            if(pwd1 == ""){
                document.getElementById("pwdCheckText").innerHTML = "비밀번호를 입력해 주세요.";
                document.getElementById("pwd1Hidden").value = ""; 
            //정규식검사
            }else if(pwd1c == false){
                document.getElementById("pwdCheckText").innerHTML = "영문, 숫자, 특수문자를 포함, 6자리 이상 입력하세요.";
                document.getElementById("pwd1Hidden").value = ""; 
            
            //정규식 통과하면
            }else{
                document.getElementById("pwdCheckText").innerHTML = "";
                document.getElementById("pwd1Hidden").value = "1";
            }
        }

        //비번2체크
        function pwd2check(pwd){
            var pwd1 = document.getElementById("pwd1").value;
            var pwd2 = document.getElementById("pwd2").value;

            if(pwd1 == pwd2){
                document.getElementById("pwdCheckText").innerHTML = "";
                document.getElementById("pwd2Hidden").value = "1";
            }else{
                document.getElementById("pwdCheckText").innerHTML = "비밀번호가 일치하지 않습니다.";
                document.getElementById("pwd2Hidden").value = ""; 
            }
        }

        //출생년도 체크

        // function birthyearcheck(){

        //     function range(start, end){
        //         var arr = [];
        //         var length = end - start;
        //         for (var i = 0; i <= length; i++){
        //             arr[i] = start;
        //             start++;
        //         }
        //         return arr;
        //     }
            
        //    var birthYearArr = range(1910, 2020);
        //    var birthYear =document.getElementById("birthYear").value;
        //    var birthYearc = birthYearArr.includes(birthYear);

        //    if(birthYear == 0){
        //     document.getElementById("birthYearCheckText").innerHTML = "";
        //     document.getElementById("birthYearHidden").value = "1";
        //    }else if(birthYearc == true){
        //     document.getElementById("birthYearCheckText").innerHTML = "";
        //     document.getElementById("birthYearHidden").value = "1";
        //    }else{
        //     document.getElementById("birthYearCheckText").innerHTML = "정확히 입력해 주세요.";
        //     document.getElementById("birthYearHidden").value = "";
        //    }
        // }


        function birthyearcheck(){
            var birthYearReg = /^19|20/g;
            var birthYear = document.getElementById("birthYear").value;
            var birthYearc = birthYearReg.test(birthYear);

            if(birthYearc == false){
                document.getElementById("birthYearCheckText").innerHTML = "정확히 입력해 주세요.";
                document.getElementById("birthYearHidden").value = "";
            }else if(birthYear.length != 4){
                document.getElementById("birthYearCheckText").innerHTML = "정확히 입력해 주세요.";
                document.getElementById("birthYearHidden").value = "";
            }else{
                document.getElementById("birthYearCheckText").innerHTML = "";
                document.getElementById("birthYearHidden").value = "1";
            }
        }

        // var idHidden, emailHidden, pwd1Hidden, pwd2Hidden, birthYearHidden;
        // idHidden = document.getElementById("idHidden").value;
        // emailHidden = document.getElementById("emailHidden").value;
        // pwd1Hidden = document.getElementById("pwd1Hidden").value;
        // pwd2Hidden = document.getElementById("pwd2Hidden").value;
        // birthYearHidden = document.getElementById("birthYearHidden").value;

        // if(idHidden == 1 || emailHidden == 1 || pwd1Hidden == 1 || pwd2Hidden == 1 || birthYearHidden == 1){
        //     document.getElementById("btn_signup").disabled = false;
        // }else{
        //     document.getElementById("btn_signup").disabled = true;

        // }
        

    </script>
    
</body>

</html>