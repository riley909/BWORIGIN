<?php
include_once '/var/www/html/menu/menu.php';
require '/var/www/html/menu/db.php';
error_reporting(E_ALL);
ini_set("display_errors", 1);
// 비로그인 차단
if (!isset($_SESSION['session_id'])) {
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
$sessionId = $_SESSION['session_id'];
$reviewNum = $_GET['review_num'];

$sql = queryResult("SELECT *FROM review_note WHERE id = '$sessionId' AND review_num = '$reviewNum'");
$row = $sql->fetch_array();
if ($sql->num_rows > 0) {
    $title = $row['title'];
    $content = $row['content'];
    $date = $row['date'];
    $time = $row['time'];
    $tv_id = $row['tv_id'];
}
?>
<div class="dash-content">
    <div class="container-fluid">
        <div class="dash-title">
            <div class="row">
                <div class="col-xl-8">
                    <div class="card easion-card">
                        <div class="card-header">
                            <div class="easion-card-title">
                                <?=$title?>
                            </div>
                        </div>
                        <div class="card-body">
                            <?=$content?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <!-- url로(GET) review_num 변수를 넘겨주고 edit~페이지에서 받는다 -->
            <a href="editReview.php?review_num=<?= $reviewNum ?>" class="btn btn-sm btn-info">수정</a>
            <!-- js컨펌창에 php변수를 넘기는 과정에서 매개변수로 데이터를 넣어주었더니 잘 적용된다 -->
            <!-- 매개변수 없이 그냥 js변수로 변환시켜봤더니 for문이 돌아가는것을 따라가지 않고 3에 값이 고정된다(??) -->
            <button type="button" class="btn btn-sm btn-info" onclick="confirmDelete('<?=$reviewNum?>');">삭제</button>
        </div>
        <!-- 댓글 작성창 -->
        <form action="applyComment.php" method="post" id="commentForm">
            <div class="container-fluid mt-5">
                <div class="form-group col-md-8">
                    <label for="comment"><i class="fas fa-comment mr-2"></i>Comment</label>
                    <textarea class="form-control" rows="5" name="commentContent" id="commentContent"></textarea>
                    <input type="hidden" name="commentId" id="commentId" value="<?=$sessionId?>">
                    <input type="hidden" name="reviewNum" id="reviewNum" value="<?=$reviewNum?>">
                    <input type="hidden" name="commentDate" id="commentDate" value="<?=date('Y-m-d')?>">
                    <input type="hidden" name="commentTime" id="commentTime" value="1">
                    <button type="submit" class="btn btn-sm btn-info pull-right mt-2" id="writeCommentBtn">작성하기</button>
                </div>
            </div>
        </form>

        <!-- 댓글 출력창 -->
        <?php
        $sqlComment = queryResult("SELECT *FROM comments WHERE review_num = '$reviewNum'");
        $totalCommentNum = mysqli_num_rows($sqlComment); ?>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="page-header">
                        <!-- 총 댓글의 숫자 출력 -->
                        <h3><small class="pull-right"><?=$totalCommentNum?> comments</small></h3>
                    </div>
                    <div class="comments-list">

                        <?php
                        while($rowComment = $sqlComment->fetch_array()){
                            $id = $rowComment['id'];
                            $reviewNum = $rowComment['review_num'];
                            $commentContent = $rowComment['comment_content'];
                            $commentDate = $rowComment['comment_date'];
                            $commentTime = $rowComment['comment_time'];
                            ?>
                        <div class="media">
                            <a class="media-left" href="#">
                                <img src="http://lorempixel.com/40/40/people/1/">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading user_name"><?=$id?></h4>
                                    <div id="commentContent"><?=$commentContent?></div>
                                    <input type="hidden" id="reviewNum" value="<?=$reviewNum?>"/>
                                <!-- 내가 쓴 댓글일 경우만 수정, 삭제버튼 노출 -->
                                <?php if($sessionId == $id){ ?>
                                <p><small><button type="button" style="border: 0; outline:0; color:blue;">수정</button>
                                <button type="button" style="border: 0; outline:0; color:blue;" onclick="deleteComment()">삭제</button></small></p>
                                <?php }?>
                            </div>
                            <p class="pull-right">
                                <small><?= $commentDate ?></small><br>
                                <small><?= $commentTime ?></small>
                            </p>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 삭제버튼 확인부분 -->
<script>
    function confirmDelete(reviewNum) {
        $.confirm({
            icon: 'fas fa-exclamation-triangle',
            title: '삭제 확인',
            content: '리뷰를 삭제할까요?',
            buttons: {
                삭제: function() {
                    location.href = "deleteReview.php?review_num=" + reviewNum;
                },
                취소: function() {}
            }
        });
    }
</script>

</div>
<script src="../js/applyComment.js"></script>
<script src="../js/deleteComment.js"></script>
<script src="../js/commentUpdate.js"></script>
<?php include '/var/www/html/menu/bottom.html';?>