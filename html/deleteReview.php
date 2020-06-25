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
$reviewNum = $_GET['review_num'];

$sql = queryResult("DELETE FROM review_note WHERE id = '$id' AND review_num = '$reviewNum'");
echo "<script>
 $.alert({
    icon: 'fas fa-exclamation-triangle',
    title: '삭제 완료',
    content: '리뷰가 삭제되었습니다.',
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