<?php
include_once '/var/www/html/menu/menu.php';
require '/var/www/html/menu/db.php';

error_reporting(E_ALL);
ini_set("display_errors", 1);
// 비로그인 차단
if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('로그인이 필요한 서비스 입니다.')</script>";
    echo "<script>location.href='index.php'</script>";
}
$reviewNum = $_GET['review_num'];

$sql = queryResult("SELECT *FROM review_note WHERE review_num = '$reviewNum'");
$row = $sql->fetch_array();
if ($sql->num_rows > 0) {
    $title = $row['title'];
    $content = $row['content'];
    $tv_id = $row['tv_id'];
    $reviewNum = $row['review_num'];
}
?>

<main class="dash-content">
    <div class="col-xl-8">
        <form method="post" action="applyEditReview.php" id="reviewForm">
            <input type="text" class="form-control mb-4" id="summernoteTitle" name="title" maxlength="55" placeholder="" value="<?= $title ?>">
            <textarea id="summernoteEdit" name="content"><?= $content ?></textarea>
            <input type="submit" class="btn btn-info" value="수정하기" id="writeReview">
            <!-- history.back()을 사용해서 목록, 상세페이지 어디에서 취소를 눌러도 다시 뒤로 갈수있음 -->
            <a href="javascript:history.back();" class="btn btn-info text-white">취소</a>
            <input type="hidden" name="review_num" value="<?= $reviewNum ?>">
        </form>

        <script>
            $(document).ready(function() {
                $('#summernoteEdit').summernote({
                    placeholder: "리뷰를 작성해 보세요",
                    height: 360,
                    minHeight: null,
                    maxHeight: null,
                    maxwidth: 600,
                    focus: true,
                    callbacks: { // onImageUpload callback
                        onImageUpload: function(files) {
                            // 파일 여러개를 업로드 하기위해서 파일 수만큼 함수를 반복한다
                            for (let i = 0; i < files.length; i++) {
                                $.upload(files[i]);
                                console.log(files[i]);
                            }
                        }
                    }
                });
                // summernote 에디터로 불러온 이미지들을 ajax 사용해 비동기로 업로드
                // 리턴받은 data에 url이 들어있고 에디터에는 이 url을 이용해서 삽입되도록 함
                $.upload = function(file) {
                    let data = new FormData();
                    data.append('file', file, file.name);
                    $.ajax({
                        method: 'POST',
                        url: 'uploadImage.php',
                        data: data,
                        contentType: false,
                        processData: false,
                        cache: false,
                        success: function(image) {
                            $('#summernoteEdit').summernote('insertImage', image);
                            console.log("이미지 주소: " + image);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus + " " + errorThrown);
                        }
                    });
                }
            });

            // 제목을 입력하지 않고 작성버튼을 누르면 경고창이 뜨고 작성되지 않는다
            $('#writeReview').click(function() {
                if ($('#summernoteTitle').val() == '') {
                    alert('제목을 입력해 주세요.');
                    $('#summernoteTitle').focus();
                    return false; //submit이벤트 중지
                }
            });
        </script>
    </div>
</main>