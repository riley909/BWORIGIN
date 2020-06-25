<?php
header("Content-Type: text/html; charset=UTF-8");
session_start();

function console_log($data)
{
    echo "<script>console.log('PHP_CONSOLE : " . $data . "');</script>";
}
error_reporting(E_ALL);
ini_set("display_errors", 1);
// 비로그인 차단
if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('로그인이 필요한 서비스 입니다.')</script>";
    echo "<script>location.href='index.php'</script>";
}
?>

<!doctype html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600|Open+Sans:400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="../css/easion.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <!-- summernote -->
    <!-- include libraries(jQuery, bootstrap) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <!-- reviewNote.php 템플릿용 css -->
    <link rel="stylesheet" href="../css/reviewNote.css">
    <!-- jquery-confirm -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <!-- twb-pagination -->
    <script type="text/javascript" src="../js/twbs-pagination/jquery.twbsPagination.js"></script>
</head>

<body>
    <!-- collapse 버튼의 data-target, aria-controls, collapse를 적용시킬 태그의 id가 일치해야 함 -->
    <nav class="navbar navbar-light bg-light">
        <a href="index.php" class="easion-logo navbar-brand">
            <i class="fas fa-cookie-bite d-inline-block align-top"></i>
            <span>Binge Watch</span>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#searchSideBar" aria-controls="searchSideBar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

    </nav>

    <div class="container-fluid">
        <div class="row justify-content-end">
            <div class="col-xl-6">
                <form method="post" action="applyReview.php" id="reviewForm">
                    <input type="text" class="form-control mb-4" id="summernoteTitle" name="title" maxlength="55" placeholder="">
                    <textarea id="summernote" name="content"></textarea>
                    <!--#태그 -->
                    <input type="text" class="form-control mb-4" id="tag" name="tag" maxlength="55" placeholder="">
                    <input type="submit" class="btn btn-info" value="작성하기" id="writeReview">
                </form>
            </div>
            <!-- collapse되는 검색창 부분 -->
            <div class="col-xl-3">
                <div class="collapse" id=searchSideBar>
                    <div class="card-body bg-light" style="height:600px; border-radius:8px;">
                        <!-- 서치박스 -->
                        <div class="row justify-content-center mb-3">
                            <input class="form-control col-8 mr-2" type="search" placeholder="드라마 이름 검색" aria-label="Search" id="query" name="query">
                            <button class="btn btn-info my-2 my-sm-0" type="submit" id="search" name="search">Search</button>
                        </div>
                        <!-- 검색결과 출력부 -->
                        <div class="col" id="reviewSearchText">
                        </div>
                        <div id="pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // summernote
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: "리뷰를 작성해 보세요",
                height: 360,
                minHeight: null,
                maxHeight: null,
                maxwidth: 600,
                focus: true,
                callbacks: { // onImageUpload callback
                    onImageUpload: function(files) {
                        // 파일 여러개를 업로드 하기위해서 파일 수만큼 함수를 반복한다
                        for(let i = 0; i < files.length; i++){
                            $.upload(files[i]);
                            console.log(files[i]);
                        }
                    }
                }
            });

            // summernote 에디터로 불러온 이미지들을 ajax 사용해 비동기로 업로드
            // 리턴받은 data에 url이 들어있고 에디터에는 이 url을 이용해서 삽입되도록 함
            $.upload = function(file){
                let data = new FormData();
                data.append('file', file, file.name);
                $.ajax({
                    method: 'POST',
                    url: 'uploadImage.php',
                    data: data,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(image){
                        $('#summernote').summernote('insertImage', image);
                        console.log("이미지 주소: "+image);
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        console.log(textStatus + " " + errorThrown);
                    }
                });
            };
        });

        // 제목을 입력하지 않고 작성버튼을 누르면 경고창이 뜨고 작성되지 않는다
        $('#writeReview').click(function() {
            if ($('#summernoteTitle').val() == '') {
                alert('제목을 입력해 주세요.');
                $('#summernoteTitle').focus();
                return false; //submit이벤트 중지
            }
        });

        // 검색버튼
        $('#search').click(function() {
            var query = $("#query").val();
            if (query == '') {
                // 검색어를 입력하지 않았을 경우
                alert('검색어를 입력해 주세요');
                query.focus();
                return false; //submit이벤트 중지
            } else {
                var reviewSearchText = $("#reviewSearchText").html();
                $.ajax({
                        method: "GET",
                        url: "https://api.themoviedb.org/3/search/tv?language=ko&include_adult=false",
                        data: {
                            "api_key": "d579af00349a9e85a6a32ff41c93ad8c",
                            "page": "1",
                            "query": query
                        },
                        dataType: "json",
                    })
                    .done(function(reviewSearchResult) {
                        console.log(reviewSearchResult);
                        console.log(reviewSearchResult.total_results);
                        var htmlCard = $("<div>");
                        for (i = 0; i < 5; i++) {
                            var image = reviewSearchResult.results[i].poster_path == null ?
                                "/menu/img/no-image-icon-23485.png" : "https://image.tmdb.org/t/p/w92/" + reviewSearchResult.results[i].poster_path;
                            var name = reviewSearchResult.results[i].name;
                            var firstAirDate = reviewSearchResult.results[i].first_air_date;
                            var tv_id = reviewSearchResult.results[i].id;
                            // 반복할 html양식을 변수로 만들고 한줄씩 더해나간다
                            htmlCard.append("<div class=\"card mb-3\" id=\"addTvShow\" style=\"border-radius: 8px;\">" +
                                "<div class=\"row no-gutters\"><div class=\"col-2\">" +
                                "<img src ='" + image + "' class=\"card-img\" style=\"height:82px; border-radius: 8px 0px 0px 8px;\"/>" +
                                "</div><div class=\"col-10\"><div class=\"card-body\"><h6 class=\"card-title\">" + name + "</h6>" +
                                "<div class=\"card-text mb-2\"><small class=\"text-muted\">" + firstAirDate + "</small>" +
                                "<input type=\"hidden\" id=\"writeReviewTvId\" value=" + tv_id + ">" +
                                "</div></div></div></div></div>")
                            $("#reviewSearchText").append(htmlCard);
                        }
                        htmlCard.append("</div>");
                        $("#reviewSearchText").html(htmlCard);
                    });
                // TODO: 반복문 안에서 개별 클릭해서 id 정보 받아오기   
            }
        });
    </script>

    <?php include_once '/var/www/html/menu/bottom.html'; ?>