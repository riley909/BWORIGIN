<?php include_once '/var/www/html/menu/menu.php';?>

<div class="dash-content">
    <div class="container-fluid">
        <div class="row row-cols-6"></div>
    </div>
</div>
<script>
  // 불러올 데이터가 더 없을 경우 무한스크롤 진행을 종료하기 위한 전역변수
  let isEnd = false;
  //불러올 api데이터의 페이지 번호
  let popularTvPage = 1;

  $(function(){
        $(window).scroll(function(){
            let $window = $(this);
            let scrollTop = $window.scrollTop();
            let windowHeight = $window.height();
            let documentHeight = $(document).height();
            // console.log("documentHeight:" + documentHeight + " | scrollTop:" + scrollTop + " | windowHeight: " + windowHeight );
            
            // 스크롤바가 바닥 전 30px까지 도달 하면 리스트를 가져온다.
            if( scrollTop + windowHeight + 30 > documentHeight ){
				//스크롤할때마다 페이지를 1씩 증가시킨다
				popularTvPage++;
                fetchList();
            }
        })
		//스크롤을 하기 전에는 데이터가 없으므로 api호출을 먼저 한번 해준다
        fetchList();
    })
    
    let fetchList = function(){
        if(isEnd == true){
            return;
        }
		// 인기 드라마 리스트를 불러온다
		// TODO:사진 주소 데이터 어떻게 할것인지 생각해보기
		$.ajax({
			method: "GET",
			url: "https://api.themoviedb.org/3/tv/popular?language=ko",
			data: { "api_key": "d579af00349a9e85a6a32ff41c93ad8c", "page": popularTvPage },
			dataType: "json"
		})
		.done(function( popularResult ) {
			console.log(popularTvPage);
			console.log(popularResult);
			var totalPopularPages = popularResult.total_pages;
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
			//api데이터의 총 페이지 수보다 불러온 페이지 번호가 커지면 전역변수 isEnd를 true로 바꾸고 스크롤을 중단한다
			if( popularTvPage > totalPopularPages ){
				isEnd = true;
			}
		});
    }
</script>

<?php include_once '/var/www/html/menu/bottom.html';?>
