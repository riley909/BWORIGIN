<?php include 'menu.php';?>

<div class="dash-content">
    <div class="container-fluid">
    <h3>SF 판타지</h3>
        <div class="row row-cols-6">
        </div>
    </div>
</div>

<script>
// 장르 아이디로 리스트를 불러온다
  $.ajax({
  method: "GET",
  url: "https://api.themoviedb.org/3/discover/tv?language=ko&sort_by=popularity.desc&include_null_first_air_dates=false",
  data: { "api_key": "d579af00349a9e85a6a32ff41c93ad8c", "page": "1", "with_genres": "10765" },
  dataType: "json"
})
  .done(function( sfFantasyResult ) {
    for (i = 0; i < sfFantasyResult.results.length; i++) {
      var image = sfFantasyResult.results[i].poster_path == null ? "/menu/img/no-image-icon-23485.png" : "https://image.tmdb.org/t/p/w185/" + sfFantasyResult.results[i].poster_path;
      var name = sfFantasyResult.results[i].name;
      var firstAirDate = sfFantasyResult.results[i].first_air_date;
      var tv_id = sfFantasyResult.results[i].id;
      // 반복할 html양식을 변수로 만들고 한줄씩 더해나간다
      var htmlCard = "<div class=\"card\" style=\"width: 18rem; border-radius:8px; margin:8px;\">";
      htmlCard += "<img src ='" + image + "' style=\"height:285px; border-radius:8px 8px 0px 0px;\"/>";
      htmlCard += "<div class=\"card-body\">";
      htmlCard += "<div class=\"card-text font-weight-bold\"><a href=\"tvShowInfo.php?tv_id="+ tv_id +"\">"+ name +"</a></div>";
      htmlCard += "<div class=\"card-text text-secondary\" style=\"font-size:0.9em;\">"+ firstAirDate +"</div>";
      htmlCard += "</div>";
      htmlCard += "</div>";
      // 반복할 html템플릿이 완성되었으면 상위 태그에 append 해준다
      $(".row").append(htmlCard);
  }
  });
</script>

<?php include 'bottom.html';?>