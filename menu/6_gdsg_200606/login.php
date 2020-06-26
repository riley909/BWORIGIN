<?php
// 쿠키가 있으면 변수에 쿠키값 넣음
if(isset($_COOKIE['saveid'])){
  $cookie_id = $_COOKIE['saveid'];

// 쿠키 없으면 빈값
}else {
  $cookie_id = "";
}
 ?>


<!DOCTYPE html>
<html lang="kr">
  <head>
    <meta charset="utf-8">
    <title>로그인</title>
    <link rel="stylesheet" href="/stdbhs/bootstrap-4.4.1-dist/css/bootstrap.css">
  </head>
  <body>

    <div class="row justify-content-center">
      <h2 style="font-weight:900; letter-spacing:-0.035em; line-height:1; text-decoration:none; margin-top:20px;"><a href="index.php" style="color:#252122; text-decoration:none;">Study Bahasa</a></h2>
    </div>

    <form action="/stdbhs/templ/loginresult.php" method="post">

          <!-- placeholder=힌트같은거. required넣으면 안쓰면 못넘어감.
          value에 쿠키에 저장된 아이디를 넣으면 쿠키가 있을경우 아이디 작성란에 미리 아이디를 불러온다. -->
          <!-- <div class="card" style="width:18rem; margin: auto; position:absolute; top:10%; left:40%;">
            <div class="card-body">
              <input type="text" name="id"
                  value="<=$cookie_id?>" placeholder="ID" required><br>
              <input type="password" name="pwd" placeholder="PASSWORD" required><br>
              <button type="submit" class="btn btn-primary">Login</button><br> -->

            <!-- 체크박스 value 설정안하면 기본값은 on으로 전송된다(?) -->
            <!-- <input type="checkbox" name="id_check">ID저장&nbsp -->
            <!-- 링크걸때 페이지가 동일 폴더에 있지 않으면 ../ 을 먼저 쳐서 현재 폴더를 벗어나기 -->
            <!-- <a href="join.html">Sign up</a>
            </div>
          </div> -->



          <div class="container" style="position:relative; top:30px;">
              <div class="row justify-content-center">
                <div class="col-md-5">
                  <div class="card-group mb-0">
                    <div class="card p-4">
                      <div class="card-body">
                        <h1>Login</h1>

                        <p class="text-muted">Sign In to your account</p>
                        <div class="input-group mb-3">
                          <span class="input-group-addon"><i class="fa fa-user"></i></span>

                          <input type="text" name="id" class="form-control" placeholder="User ID" value="<?=$cookie_id?>">

                        </div>

                        <div class="input-group mb-4">
                          <span class="input-group-addon"><i class="fa fa-lock"></i></span>

                          <input type="password" name="pwd" class="form-control" placeholder="Password">

                        </div>

                          <input type="checkbox" name="id_check"style="margin-bottom:15px;">&nbsp;아이디 기억하기&nbsp;

                        <div class="row">
                          <div class="col-6" style="margin-top:20px;">
                            <input type="submit" class="btn btn-primary px-4" value="Login">
                          </div>
                          <div class="col-6 text-right">
                            <!-- 새창띄우기 -->
                            <a href="javascript:void(window.open('findID.html', '비밀번호 찾기', 'top=50, left=100, width=500, height=600, status=no, menubar=no, toolbar=no, resizable=no'))" class="btn btn-link px-0" style="text-decoration:none;">아이디 찾기</a>
                            <a href="javascript:void(window.open('findPwd.html', '비밀번호 찾기', 'top=50, left=100, width=500, height=600, status=no, menubar=no, toolbar=no, resizable=no'))" class="btn btn-link px-0" style="text-decoration:none;">비밀번호 찾기</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

    </form>
  </body>
</html>
