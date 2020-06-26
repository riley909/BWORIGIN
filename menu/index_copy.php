<?php include_once '/var/www/html/menu/menu.php';?>

<div class="dash-content">
    <div class="container-fluid">
        <div class="row row-cols-6"></div>
    </div>
</div>
<script>
  // 인기 드라마 리스트를 불러온다
  // TODO:사진 주소 데이터 어떻게 할것인지 생각해보기
  $.ajax({
  method: "GET",
  url: "https://api.themoviedb.org/3/tv/popular?language=ko",
  data: { "api_key": "d579af00349a9e85a6a32ff41c93ad8c", "page": "1" },
  dataType: "json"
})
  .done(function( popularResult ) {
    for (i = 0; i < popularResult.results.length; i++) {
      var image = popularResult.results[i].poster_path == null ? 
      "/menu/img/no-image-icon-23485.png" : "https://image.tmdb.org/t/p/w185/" + popularResult.results[i].poster_path;
      var name = popularResult.results[i].name;
      var firstAirDate = popularResult.results[i].first_air_date;
      var tv_id = popularResult.results[i].id;
      // 반복할 html양식을 변수로 만들고 한줄씩 더해나간다
      var htmlCard = "<div class=\"card\" style=\"width: 18rem; border-radius:8px; margin:8px;\">";
      // htmlCard += "<i class=\"fas fa-cookie-bite\"></i>";
      htmlCard += "<img src ='" + image + "' style=\"height:285px; border-radius:8px 8px 0px 0px;\"/>";
      htmlCard += "<div class=\"card-body\">";
      htmlCard += "<div class=\"card-text font-weight-bold\"><a href=\"tvShowInfo.php?tv_id="
                    + tv_id +"\" class=\"text-decoration-none\">"+ name +"</a></div>";
      htmlCard += "<div class=\"card-text text-secondary\" style=\"font-size:0.9em;\">"+ firstAirDate +"</div>";
      htmlCard += "</div>";
      htmlCard += "</div>";
      // 반복할 html템플릿이 완성되었으면 상위 태그에 append 해준다
      $(".row").append(htmlCard);
  }
  });
</script>

<?php include_once '/var/www/html/menu/bottom.html';?>
