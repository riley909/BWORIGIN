<?php
header("Content-Type: text/html; charset=UTF-8");
session_start();

function console_log($data){
    echo "<script>console.log('PHP_CONSOLE : ".$data."');</script>";
  }
?>

<!doctype html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link
            rel="stylesheet"
            href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
            integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz"
            crossorigin="anonymous">
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:400,600|Open+Sans:400,600,700"
            rel="stylesheet">
        <link rel="stylesheet" href="../../css/easion.css">
        <link rel="stylesheet" href="../../css/commentList.css">
        <script
            src="https://code.jquery.com/jquery-3.5.1.js"
            integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
            crossorigin="anonymous"></script>
        <!-- summernote -->
        <!-- include libraries(jQuery, bootstrap) -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <!-- include summernote css/js -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
        <!-- reviewNote.php 템플릿용 css -->
        <link rel="stylesheet" href="../../css/reviewNote.css">
        <!-- jquery-confirm -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    </head>

    <body>
        <div class="dash">
            <div class="dash-nav dash-nav-dark">
                <header>
                    <a href="#!" class="menu-toggle">
                        <i class="fas fa-bars"></i>
                    </a>
                    <a href="../index.php" class="easion-logo">
                        <i class="fas fa-cookie-bite"></i>
                        <span>Binge Watch</span></a>
                </header>
                <nav class="dash-nav-list">
                    <div class="dash-nav-dropdown">
                        <a href="reviewNote.php" class="dash-nav-item dash-nav-dropdown-toggle">
                            <i class="fas fa-book-open"></i>
                            리뷰노트
                        </a>
                    </div>
                    <div class="dash-nav-dropdown ">
                        <a href="#!" class="dash-nav-item dash-nav-dropdown-toggle">
                            <i class="fas fa-clipboard-list"></i>
                            찾아보기
                        </a>
                        <div class="dash-nav-dropdown-menu">
                            <a href="../category/actionAdventure.php" class="dash-nav-dropdown-item">액션/어드벤처</a>
                            <a href="../category/crime.php" class="dash-nav-dropdown-item">범죄</a>
                            <a href="../category/drama.php" class="dash-nav-dropdown-item">드라마</a>
                            <a href="../category/mystery.php" class="dash-nav-dropdown-item">미스터리</a>
                            <a href="../category/sfFantasy.php" class="dash-nav-dropdown-item">SF/판타지</a>
                            <a href="../category/comedy.php" class="dash-nav-dropdown-item">코미디</a>
                            <a href="../category/documentary.php" class="dash-nav-dropdown-item">다큐멘터리</a>
                            <a href="../category/warPolitics.php" class="dash-nav-dropdown-item">전쟁/정치</a>
                        </div>
                    </div>
                    <div class="dash-nav-dropdown">
                        <a href="http://localhost/html/live_streaming" class="dash-nav-item dash-nav-dropdown-toggle">
                            <i class="fas fa-video"></i>
                            방송 보기
                        </a>
                    </div>
                    <div class="dash-nav-dropdown">
                        <a href="#!" class="dash-nav-item dash-nav-dropdown-toggle">
                            <i class="fas fa-info-circle"></i>
                            문의하기
                        </a>
                    </div>
                </nav>
            </div>

            <!-- 상단 메뉴바 -->
            <div class="dash-app">
                <header class="dash-toolbar">
                    <a href="#!" class="menu-toggle">
                        <i class="fas fa-bars"></i>
                    </a>
                    <a href="#!" class="searchbox-toggle">
                        <i class="fas fa-search"></i>
                    </a>
                    <form class="searchbox" action="../searchResult.php" method="get">
                        <a href="#!" class="searchbox-toggle">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <button type="submit" class="searchbox-submit" id="search">
                            <i class="fas fa-search"></i>
                        </button>
                        <input
                            type="text"
                            class="searchbox-input col-6"
                            id="query"
                            name="query"
                            placeholder="드라마 제목, 배우 검색">
                    </form>

                    <!-- 세션아이디가 있으면 내정보, 로그아웃 버튼을 보여준다 -->
                    <?php if(isset($_SESSION['session_id'])){
                    $sessionId = $_SESSION['session_id']; ?>
                    <div class="tools">
                        <a href="#!" class="tools-item">
                            <i class="fas fa-bell"></i>
                            <i class="tools-item-count">4</i>
                        </a>
                        <div class="dropdown tools-item">
                            <a
                                href="#"
                                class=""
                                id="dropdownMenu1"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa-user"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                                <a class="dropdown-item" href="../myaccount.php"><?=$sessionId." 님"?></a>
                                <a class="dropdown-item" href="../logout.php">로그아웃</a>
                            </div>
                        </div>
                    </div>

                    <!-- 세션없으면 로그인, 회원가입 버튼을 보여준다 -->
                <?php }else{ ?>
                    <div class="tools">
                        <a
                            class="btn btn-info"
                            href="../signup.php"
                            style="color:white; margin-right:10px;">회원 가입</a>
                        <a class="btn btn-info" href="../login.php" style="color:white">로그인</a>
                    </div>

                    <?php }?>
                </header>
                <script>
                    $('#search').click(function () {
                        if ($('#query').val() == '') {
                            alert('검색어를 입력해 주세요');
                            $('#query').focus();
                            return false;  //submit이벤트 중지
                        }
                    });
                </script>