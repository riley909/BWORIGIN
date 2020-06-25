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
    $sessionId = $_SESSION['session_id'];
    $sql = queryResult("SELECT *FROM review_note WHERE id='$sessionId'");
    $totalReviewNum = mysqli_num_rows($sql); //총 게시물 수

    //페이지 링크를 담을 변수
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page = 1;
    }

    $pageScale = 5; //한 화면에 보여줄 게시물 수
    $totalPageNum = ceil($totalReviewNum/$pageScale); //총 페이지수 = 총 게시물수/페이지당 게시글 수
    $pageStart = ($page-1) * $pageScale; //페이지당 시작할 글의 시작번호(ex.1페이지에는 0번부터 4번)
    $blockScale = 5; //한번에 보여줄 블록 수
    $currentBlock = ceil($page/$blockScale); //현재 페이지에서 뜨는 블록범위
    $blockStart = (($currentBlock - 1) * $blockScale) + 1; //블록 시작번호
    $blockEnd = $blockStart + $blockScale - 1; //블록 끝번호

    //블록의 끝번호가 총 페이지 수보다 많으면 블록 끝번호 = 총 페이지수
    if($blockEnd > $totalPageNum){
        $blockEnd = $totalPageNum;
    }
    $totalBlockNum = ceil($totalPageNum/$blockScale); //페이징 블록수 = 총 페이지수/한블록당 페이지수
    $sqlLimit = queryResult("SELECT *FROM review_note WHERE id='$sessionId' ORDER BY review_num DESC LIMIT $pageStart, $pageScale");
?>

<div class="container mt-5 mb-5">
    <div class="row">
        <div>
        <div class="row">
        <div><?=$totalReviewNum?>개의 리뷰가 있습니다.</div>
                <a href="writeReview.php" class="btn btn-info mb-2 text-white offset-11">리뷰하기</a>
        </div>
            <?php

// 게시글양식 반복문 시작
while($rowLimit = $sqlLimit->fetch_array()){
    $imgReg = "/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i";
    $id = $rowLimit['id'];
    $title = $rowLimit['title'];
    $content = $rowLimit['content'];
    if(preg_match($imgReg, $content, $match)){
        $content = preg_replace( $imgReg, "", $content);
    }
    $date = $rowLimit['date'];
    $time = $rowLimit['time'];
    $tv_id = $rowLimit['tv_id'];
    $reviewNum = $rowLimit['review_num'];
    empty(!$rowLimit['thumbnail']) ? $thumbnali = $rowLimit['thumbnail'] : $thumbnali = "img-uploads/no_image2.jpg";
?>
            <div class="bg-white p-3 rounded mt-3" style="width:1080px;">
                <div class="row">
                    <!-- 사진 삽입부분 -->
                    <div class="col-md-3">
                        <div class="d-flex flex-column justify-content-center">
                        <img src="<?=$thumbnali?>" class="card-img" style="position: absolute; width:95%; height:95%;"/>
                            <span class="mb-4"></span>
                        </div>
                    </div>
                    <!-- 오른쪽. 글 요약부분 -->
                    <div class="col-md-7 border-right">
                        <div class="listing-title">
                            <a href="viewReview.php?review_num=<?=$reviewNum?>" class="ellipsis text-decoration-none h4 mb-4 mt-1 alert alert-info"><?=$title?></a>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <div class="mr-5">
                                <span class="font-weight-bold">드라마 정보</span></div>

                            <!-- TODO: 별점 -->
                            <div class="d-flex flex-row align-items-center ratings">
                                <div class="stars mr-2">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <span class="rating-number">5</span>
                            </div>
                        </div>

                        <!-- TODO: 글 줄임 짤리지 않고 줄간격 일정하게 3줄 나오게하기 -->
                        <div class="ellipsis-multi mb-4">
                            <?=$content?>
                        </div>

                        <!-- TODO: 태그 -->
                        <!-- <div class="tags">
                            <span>Microsoft</span><span>Azure</span><span>Development</span>
                        </div> -->
                    </div>

                    <!-- 왼쪽. 아이디, 날짜, 시간, 댓글수 -->
                    <div class="d-flex col-md-2">
                        <div class="d-flex flex-column justify-content-start user-profile w-100">
                            <!-- 글쓴이 정보 -->
                            <div class="d-flex user mt-2">
                                <img class="rounded-circle" src="img-uploads/userDefault.png" width="50">
                                <div class="ml-3 mt-4">
                                    <span class="d-block font-weight-bold"><?=$id?></span>
                                </div>
                            </div>
                            <div class="text-secondary mt-4">
                                <span class="d-block"><?=$date?></span>
                                <span><?=$time?></span>
                            </div>
                            <div class="mt-5">
                                <!-- url로(GET) review_num 변수를 넘겨주고 edit~페이지에서 받는다 -->
                                <a href="editReview.php?review_num=<?=$reviewNum?>" class="btn btn-sm btn-info">수정</a>
                                <!-- XXX: js컨펌창에 php변수를 넘기는 과정에서 매개변수로 데이터를 넣어주었더니 잘 적용된다 -->
                                <!-- 매개변수 없이 그냥 js변수로 변환시켜봤더니 for문이 돌아가는것을 따라가지 않고 3에 값이 고정된다(??) -->
                                <button
                                    type="button"
                                    class="btn btn-sm btn-info"
                                    onclick="confirmDelete('<?=$reviewNum?>');">삭제</button>
                            </div>

                            <!-- 삭제버튼 확인부분 -->
                            <script>
                                function confirmDelete(reviewNum) {
                                    $.confirm({
                                        icon: 'fas fa-exclamation-triangle',
                                        title: '삭제 확인',
                                        content: '리뷰를 삭제할까요?',
                                        buttons: {
                                            삭제: function () {
                                                location.href = "deleteReview.php?review_num=" + reviewNum;
                                            },
                                            취소: function () {}
                                        }
                                    });
                                }
                            </script>

                        </div>
                    </div>
                </div>
            </div>
            <!-- 반복문 끝 -->
            <?php }?>

            <!-- 페이징 -->
            <nav aria-label="...">
                <ul class="pagination">

                <?php 
            // 현재 페이지가 1보다 작거나 같으면 처음 버튼 비활성화
            if($page <= 1){
                echo "<li class=\"page-item disabled\"> 
                <span class=\"page-link\"><<</span></li>";
            }else{
                // 아니면 1페이지로 갈수있는 버튼 활성화
                echo "<li class=\"page-item\">
                <a class=\"page-link\" href=\"?page=1\"><<</a>
            </li>";
            }
            // 현재 페이지가 1보다 작거나 같으면 이전버튼 없음
            if($page <= 1){
               
            // 1보다 크면 이전으로 이동할수 있도록 pre 변수를 생성
            // ?뒤에 전달할 변수명 = 값 을 붙여 링크해준다
            }else{
                $pre = $page - 1;
                echo "<li class=\"page-item\">
                <a class=\"page-link\" href=\"?page=$pre\">Previous</a>
            </li>";
            }
            // 가운데 숫자 블록 부분
            for($i=$blockStart; $i<=$blockEnd; $i++){ 
                //블록시작번호가 마지막번호보다 작거나 같을 때까지 $i를 반복시킨다
                if($page == $i){ 
                    // 현재 페이지가 $i와 같으면 active 클래스를 사용하여 위치 표시
                    // 현재페이지이므로 링크하지 않아도 된다
                  echo "<li class=\"page-item active\" aria-current=\"page\">
                  <span class=\"page-link\">$i
                      <span class=\"sr-only\">(current)</span></span></li>";
                }else{
                  echo "<li class=\"page-item\">
                  <a class=\"page-link\" href=\"?page=$i\">$i</a></li>";
                }
              }
              if($currentBlock >= $totalBlockNum){ 
                //만약 현재 블록이 블록 총개수보다 크거나 같다면 빈 값
              }else{
                // 다음으로 이동할수 있도록 next변수 생성
                $next = $page + 1;
                echo "<li class=\"page-item\">
                        <a class=\"page-link\" href=\"?page=$next\">Next</a></li>";
              }
            //   페이지가 총 페이지수보다 많거나 같으면 마지막버튼 비활성화
              if($page >= $totalPageNum){
                echo "<li class=\"page-item disabled\"> 
                        <span class=\"page-link\">>></span></li>";
              }else{
                //   아니면 끝페이지로 갈수있는 버튼 활성화
                echo "<li class=\"page-item\">
                        <a class=\"page-link\" href=\"?page=$totalPageNum\">>></a>
                    </li>";
              }
              ?>
                </ul>
            </nav>
        </div>
    </div>
</div>
<?php }?>
<?php include_once '/var/www/html/menu/bottom.html';?>