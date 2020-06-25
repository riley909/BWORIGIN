<?php 
include '/var/www/html/menu/menu.php';
require '/var/www/html/menu/db.php';

$query = $_GET['query'];
console_log($query);
?>

<!-- 드라마 검색결과 불러오는 부분 시작 -->
<div class="dash-content">
    <div class="container-fluid" id="tvShowSearchResult">
	</div>
	<!-- 드라마 검색결과와 리뷰 검색결과를 나눠주는 분리선 -->
    <div class="mt-4 mb-5" style="height: 2px; background-color: #C5C5C5;"></div>
    
<script>
  $.ajax({
  method: "GET",
  url: "https://api.themoviedb.org/3/search/tv?language=ko&include_adult=false",
  data: { "api_key": "d579af00349a9e85a6a32ff41c93ad8c", "page": "1", "query": "<?=$query?>" },
  dataType: "json"
})
  .done(function( searchResult ) {
    var query = "<?=$query?>";
      console.log(query);
      console.log(searchResult);
      if(searchResult.results.length > 0){
        var htmlCard = $("<div>");
        for (i = 0; i < 3; i++) {
          // 출력 3개로 제한
          var image = searchResult.results[i].poster_path == null ? 
          "/menu/img/no-image-icon-23485.png" : "https://image.tmdb.org/t/p/w154/" + searchResult.results[i].poster_path;
          var name = searchResult.results[i].name;
          var firstAirDate = searchResult.results[i].first_air_date;
          var overView = searchResult.results[i].overview;
          var tv_id = searchResult.results[i].id;
          // 반복할 html양식을 변수로 만들고 한줄씩 더해나간다
          htmlCard.append("<div class=\"card mb-3\" style=\"border-radius: 8px;\">"
          +"<div class=\"row no-gutters\">"
          +"<div class=\"col-md-1\">"
          +"<img src ='" + image + "' class=\"card-img\" style=\"width:100px;height:150px; border-radius: 8px 0px 0px 8px;\"/>"
          +"</div>"
          +"<div class=\"col-md-11\">"
          +"<div class=\"card-body\">"
          +"<h4 class=\"card-title\"><a href=\"tvShowInfo.php?tv_id="+ tv_id +"\" class=\"text-decoration-none\">"+ name +"</a></h4>"
          +"<div class=\"card-text mb-4\"><small class=\"text-muted\">"+ firstAirDate +"</small></div>"
          +"<p class=\"card-text ellipsis-multi mr-3\">"+ overView +"</p>"
          +"</div></div></div></div>");
          $("#tvShowSearchResult").append(htmlCard);
        }
        htmlCard.append("</div>"
        +"<div class=\"offset-11\"><a href=\"searchResultTvShowForMore.php?query="+query+"\">더 보기</a></div>");
        $("#tvShowSearchResult").html(htmlCard);
      }else{
        var htmlCard = "<div class=\"bg-light\" style=\"height:280px;\">";
          htmlCard += "<div class=\"row no-gutters\">";
          htmlCard += "<div class=\"card-body mt-5\">";
          htmlCard += "<h4 class=\"card-title text-muted\" style=\"text-align:center;\">검색 결과가 없습니다.</h4>"
          htmlCard += "</div>";
          htmlCard += "</div>";
          htmlCard += "</div>";
          // 반복할 html템플릿이 완성되었으면 상위 태그에 append 해준다
          $("#tvShowSearchResult").append(htmlCard);
      }
  });
</script>

<!-- 리뷰 검색결과 불러오는 부분 시작 -->
<div class="container-fluid" id="ReviewSearchResult">
<?php
// TODO: 나중에 태그, 드라마정보 추가되면 검색조건에 추가
//review_note테이블에서 title이나 content에 $query가 포함되는 결과중 3개를 조회
$sql = queryResult("SELECT *FROM review_note WHERE title LIKE '%$query%' OR content LIKE '%$query%' LIMIT 3");

// db조회결과가 있으면 결과물을 반복문으로 출력한다
if($sql->num_rows > 0){
    while($row = $sql->fetch_array()){
        $id = $row['id'];
        $title = $row['title'];
        $content = $row['content'];
        $date = $row['date'];
        $time = $row['time'];
        $tv_id = $row['tv_id'];
        $reviewNum = $row['review_num'];
?>
            <div class="bg-white p-3 rounded mt-3" style="width:1080px;">
                <div class="row">
                    <!-- 사진 삽입부분 -->
                    <div class="col-md-3">
                        <div class="d-flex flex-column justify-content-center">
                        <img src="img-uploads/gameofthrones.jpg" class="card-img" style="position: absolute; width:95%; height:95%;"/>
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
        <div class="offset-11 mt-4"><a href="searchResultReviewForMore.php?query=<?=$query?>">더 보기</a></div>
<!-- db조회결과가 없으면 검색 결과 없음 메세지를 띄운다 -->
<?php }else{ ?>
   <div class="bg-light" style="height:280px;">
    <div class="row no-gutters">
        <div class="card-body mt-5">
            <h4 class="card-title text-muted" style="text-align:center;">검색 결과가 없습니다.</h4>
        </div>
    </div>
</div>
<?php } ?>

	</div>
</div>

<?php include '/var/www/html/menu/bottom.html';?>