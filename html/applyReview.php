<?php 
include_once '/var/www/html/menu/menu.php';
require '/var/www/html/menu/db.php';

error_reporting(E_ALL);
ini_set("display_errors", 1);
// 비로그인 차단
if(!isset($_SESSION['session_id'])){
echo "<script>
 $.alert({
    icon: 'fas fa-exclamation-triangle',
    title: '',
    content: '로그인이 필요한 서비스입니다.',
    buttons: {
        confirm: function () {
            location.href = 'login.php';
        }
    }
});
</script>";
}

$id = $_SESSION['session_id'];
$title = $_POST['title'];
$content = $_POST['content'];
$tv_id = 0;
$date = date("Y-m-d");
$time = date("H:i:s");
// 저장될 리뷰 본문에서 정규식을 이용해 img태그 추출하기
// 첫번째 이미지를 썸네일로 사용할것이기 때문에 가장 처음 태그만 알아내면 된다. preg_match_all을 쓸 필요 없음.
// $match[0] = img태그 전체 / $match[1] = src 값
preg_match("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $content, $match);
$thumbnail = $match[1];

$sql = queryResult("INSERT INTO review_note (id, title, content, tv_id, date, time, thumbnail) 
                    VALUES ('$id', '$title', '$content', '$tv_id', '$date', '$time', '$thumbnail')");
echo "<script>
 $.alert({
    icon: 'fas fa-exclamation-triangle',
    title: '작성 완료',
    content: '리뷰 작성이 완료되었습니다.',
    buttons: {
        confirm: function () {
            location.href = 'reviewNote.php';
        }
    }
});
</script>";
exit();

include_once '/var/www/html/menu/bottom.html';
?>