<?php 
include_once '/var/www/html/menu/menu.php';
require '/var/www/html/menu/db.php';

$query = $_GET['query'];
console_log($query);
?>

<div class="dash-content">
    <div class="container-fluid" id="tvShowSearchResult">
    </div>
</div>

<script>
  $.ajax({
  method: "GET",
  url: "https://api.themoviedb.org/3/search/tv?language=ko&include_adult=false",
  data: { "api_key": "d579af00349a9e85a6a32ff41c93ad8c", "page": "1", "query": "<?=$query?>" },
  dataType: "json"
})
  .done(function( searchResult ) {
      console.log(searchResult);
      if(searchResult.results.length > 0){
        var htmlCard = $("<div>");
        for (i = 0; i < searchResult.results.length; i++) {
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
        htmlCard.append("</div>");
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

<?php include_once '/var/www/html/menu/bottom.html';?>