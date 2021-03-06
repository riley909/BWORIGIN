<?php include_once '/var/www/html/menu/menu.php';

$tv_id = $_GET['tv_id'];
?>

<div class="container-fluid">
</div>

<div class="row bg-light ml-4">
  <!-- 기타 정보 -->
</div>

<script>
//  클릭한 대상의 tv_id를 가져와 주소에 반영한다
  $.ajax({
  method: "GET",
  url: "https://api.themoviedb.org/3/tv/"+ <?=$tv_id?> +"?language=ko",
  data: { "api_key": "d579af00349a9e85a6a32ff41c93ad8c", "page": "1" },
  dataType: "json"
})
  .done(function( infoResult ) {
      console.log(infoResult);
      var image = infoResult.poster_path == null ? 
      "/menu/img/no-image-icon-23485.png" : "https://image.tmdb.org/t/p/w342/" + infoResult.poster_path;
      var backGroundImage = infoResult.backdrop_path == null ? 
      "" : "https://image.tmdb.org/t/p/w1280/" + infoResult.backdrop_path;
      var name = infoResult.name;
      var firstAirDate = infoResult.first_air_date;
      //-기준으로 문자열을 자른다
      firstAirDate = firstAirDate.split("-");
      var overView = infoResult.overview;
      var tv_id = infoResult.id;
      // TODO: 함수로 정리해보기..
      var genre1 = infoResult.genres[0].name;
      var genre2 = infoResult.genres[1].name;
      var genreLink1 = "";
      var genreLink2 = "";
      if(genre1 == "Action & Adventure"){
        genreLink1 = "/html/category/actionAdventure.php";
      }else if(genre1 == "드라마"){
        genreLink1 = "/html/category/drama.php";
      }else if(genre1 == "범죄"){
        genreLink1 = "/html/category/crime.php";
      }else if(genre1 == "Sci-Fi & Fantasy"){
        genreLink1 = "/html/category/sfFantasy.php";
      }else  if(genre1 == "코미디"){
        genreLink1 = "/html/category/comedy.php";
      }else if(genre1 == "War & Politics"){
        genreLink1 = "/html/category/warPolitics.php";
      }else if(genre1 == "미스터리"){
        genreLink1 = "/html/category/mystery.php";
      }else if(genre1 == "다큐멘터리"){
        genreLink1 = "/html/category/documentary.php";
      }else{
        genreLink1 = "#";
      }
      var genreLink2 = "";
      if(genre2 == "Action & Adventure"){
        genreLink2 = "/html/category/actionAdventure.php";
      }else if(genre2 == "드라마"){
        genreLink2 = "/html/category/drama.php";
      }else if(genre2 == "범죄"){
        genreLink2 = "/html/category/crime.php";
      }else if(genre2 == "Sci-Fi & Fantasy"){
        genreLink2 = "/html/category/sfFantasy.php";
      }else  if(genre2 == "코미디"){
        genreLink2 = "/html/category/comedy.php";
      }else if(genre2 == "War & Politics"){
        genreLink2 = "/html/category/warPolitics.php";
      }else if(genre2 == "미스터리"){
        genreLink2 = "/html/category/mystery.php";
      }else if(genre2 == "다큐멘터리"){
        genreLink2 = "/html/category/documentary.php";
      }else{
        genreLink2 = "#";
      }
      console.log(genre1);
      console.log(genre2);
      console.log(genreLink1);
      console.log(genreLink2);
      
      // 반복할 html양식을 변수로 만들고 한줄씩 더해나간다
      var htmlCard = "<div class=\"card bg-dark text-white\">";
      htmlCard += "<img src ='" + backGroundImage + "' class=\"card-img\" style=\"opacity:15%;\"/>";
      htmlCard += "<div class=\"card-img-overlay\">";
      htmlCard += "<div class=\"row justify-content-md-center\" style=\"margin: 35px 80px 0px 80px;\">";
      htmlCard += "<div class=\"col-md-4\">";
      htmlCard += "<img src ='" + image + "' style=\"width:320px; height:480px; border-radius: 8px;\"/>";
      htmlCard += "</div>";
      htmlCard += "<div class=\"col-md-7\">";
      htmlCard += "<h2 class=\"text-white font-weight-bold\">"+name+"("+firstAirDate[0]+")"+"</h2>";
      htmlCard += "<div class=\"mb-4\"><a href="+genreLink1+" class=\" text-white text-decoration-none\">"
               +genre1+"</a>, <a href="+genreLink2+" class=\"text-white text-decoration-none\">"+genre2+"</a></div>";
      htmlCard += "<p class=\"text-white\">"+ overView +"</p>";
      htmlCard += "</div>";
      htmlCard += "</div>";
      htmlCard += "</div>";
      htmlCard += "</div>";
      // 반복할 html템플릿이 완성되었으면 상위 태그에 append 해준다
      $(".container-fluid").append(htmlCard);
  });
</script>

<?php include_once '/var/www/html/menu/bottom.html';?>
