<?php
// 쿠키가 있으면 변수에 쿠키값 넣음
if(isset($_COOKIE['savedid'])){
  $cookie_id = $_COOKIE['savedid'];

// 쿠키 없으면 빈값
}else {
  $cookie_id = "";
}
 ?>

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
            <div class="card-header bg-secondary text-white">  
            <i class="fas fa-user"></i>
            </div>
            <div class="card-body">

                <form method="post" action="loginresult.php">
                    <div class="form-group">
                        <input type="text" class="form-control" id="id" name="id" placeholder="아이디">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="pwd" name="pwd" placeholder="비밀번호">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="rememberid">
                            <label class="custom-control-label" for="rememberid">아이디 기억하기</label>
                        </div>
                    </div>
                    <div class="account-dialog-actions">
                        <button type="submit" class="btn btn-info">로그인</button>
                        <a class="account-dialog-link" href="signup.php">회원 가입</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>

</html>