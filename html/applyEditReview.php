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
}else{

$id = $_SESSION['session_id'];
$reviewNum = $_POST['review_num'];
$title = $_POST['title'];
$content = $_POST['content'];

// 수정할 리뷰 본문에서 정규식을 이용해 img태그 추출하기
preg_match("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $content, $match);
$thumbnail = $match[1];

// TODO: 드라마 정보 받아오게 되면 바꿀 것!
$tv_id = 0;

$sql = queryResult("UPDATE review_note SET title = '$title', content = '$content', tv_id = '$tv_id', thumbnail = '$thumbnail' WHERE review_num = '$reviewNum'");
echo "<script>
 $.alert({
    icon: 'fas fa-exclamation-triangle',
    title: '수정 완료',
    content: '리뷰 수정이 완료되었습니다.',
    buttons: {
        confirm: function () {
            location.href = 'viewReview.php?review_num=$reviewNum';
        }
    }
});
</script>";
exit();
}
include_once '/var/www/html/menu/bottom.html'
?>

