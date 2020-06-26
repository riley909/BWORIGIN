<!-- 상단 nav부분까지 top.php로 묶어서 불러오기 -->
<?php require('lib/top.php'); ?>

<!-- Banner -->
<section class="banner">
	<style>
		.banner {
			background: rgba(145, 167, 177, 0.5) url("images/indonesian-map-png-8.png");
			background-position: center center;
			background-size: auto 100%;
			background-repeat: no-repeat;
			text-align: center;
			position: relative;
			padding: 4em 0;
			margin: 7em 0 0 0;
		}

		.banner header {
			background-color: rgba(34, 30, 31, 0.7);
			display: inline-block;
			padding: 1em 2em;
			border-radius: 5px;
		}

		.banner header h2 {
			color: #fff;
			font-weight: 700;
			font-size: 2.5em;
			margin: 0 0 0.65em 0;
		}

		.banner header p {
			color: #9eb86d;
			padding: 0;
			font-style: normal;
			margin: 0;
			font-size: 1.5em;
		}
	</style>
	<header style="margin-bottom:40px;">
		<h2>Selamat! Ini Study Bahasa!</h2>
		<p>Learn Indonesian more effectively.</p>
	</header><br>

	<?php
	header("Content-Type: text/html; charset=UTF-8");
	$conn = new mysqli("localhost", "studybahasa", "bahasa", "StudyBahasa");
	mysqli_query($conn, 'SET NAMES utf8');

	$sql1 = "SELECT * FROM rand_word WHERE type='today1'";
	$res1 = $conn->query($sql1);
	$row1 = mysqli_fetch_assoc($res1);
	if($res1 -> num_rows > 0){
		$indonesianMain1 = $row1['indonesian'];
		$koreanMain1 = $row1['korean'];
		$englishMain1 = $row1['english'];
		$wordidMain1 = $row1['wordid'];
	}

	$sql2 = "SELECT * FROM rand_word WHERE type='today2'";
	$res2 = $conn->query($sql2);
	$row2 = mysqli_fetch_assoc($res2);
	if($res2 -> num_rows > 0){
		$indonesianMain2 = $row2['indonesian'];
		$koreanMain2 = $row2['korean'];
		$englishMain2 = $row2['english'];
		$wordidMain = $row2['wordid'];
	}
	?>


<!-- carousel -->
	<div id="carousel_home" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
			<div class="carousel-item active">
				<section class="box col-4" style="display:inline-block; margin-right:20px;">
					<header style="background:#fff;">
						<h3>오늘의 단어</h3>
					</header>
					<div class="justify-content-center" style="display:flex; width:100%;">
						<div style="width:50%;">
							<?php
							if(isset($_SESSION['session_id'])){ ?>
								<form action="addMyword.php" method="get" name="addWordForm1">
								<div>
									<button id="myWordBtn" type="button" class="btn btn-primary1" style="float:right; padding:0em 0.3em 0em 0.3em;" onclick="submitWord1()"><i class="fas fa-plus" aria-hidden="true"></i></button>
								</div>
							<?php } ?>
							<h5><?= $indonesianMain1;?></h5>
							<p><?= $koreanMain1;?></p>
							<p><?= $englishMain1;?></p>
							<input type="hidden" name="wordid" value="<?= $wordidMain1;?>">
						</form>
						</div>
						<div style="top:0; bottom:0; width:1px; background-color:#dadada; margin-right:50px; margin-left:50px;"></div>
						<div style="width:50%;">
							<?php
							if(isset($_SESSION['session_id'])){ ?>
								<form action="addMyword.php" method="get" name="addWordForm2">
								<div>
									<button id="myWordBtn" type="button" class="btn btn-primary1" style="float:right; padding:0em 0.3em 0em 0.3em;" onclick="submitWord2()"><i class="fas fa-plus" aria-hidden="true"></i></button>
								</div>
							<?php } ?>
							<h5><?= $indonesianMain2;?></h5>
							<p><?= $koreanMain2;?></p>
							<p><?= $englishMain2;?></p>
							<input type="hidden" name="wordid" value="<?= $wordidMain2;?>">
						</form>
						</div>
					</div>
					<hr>
					<footer>
						<a href="#" class="button alt">내 단어장 가기</a>
					</footer>
				</section>
			</div>
			<div class="carousel-item">
				<section class="box col-4" style="display:inline-block; margin-right:20px;">
					<header style="background:#fff;">
						<h3>이 주의 포스팅</h3>
					</header>
					<p>추천 게시물<br>1주에 한번</p>
					<hr>
					<footer>
						<a href="#" class="button alt">자세히 보기</a>
					</footer>
				</section>
			</div>
			<div class="carousel-item">
				<section class="box col-4" style="display:inline-block; margin-right:20px;">
					<header style="background:#fff;">
						<h3>추천 미디어</h3>
					</header>
					<p>미디어 라이브러리<br>추천 게시물</p>
					<hr>
					<footer>
						<a href="#" class="button alt">자세히 보기</a>
					</footer>
				</section>
			</div>
		</div>
		<a class="carousel-control-prev" href="#carousel_home" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#carousel_home" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>

</section>

<script>
function submitWord1(){
	window.open('addMyword.php', 'addWord', 'top=350, left=1180, width=300px, height=300px, location=no, fullscreen=no, status=no, menubar=no, toolbar=no, resizable=no,');
	var form1 = document.addWordForm1;
	form1.action = 'addMyword.php';
	form1.method = 'post';
	form1.target = 'addWord';
	form1.submit();
}

function submitWord2(){
	window.open('addMyword.php', 'addWord', 'top=350, left=1180, width=300px, height=300px, location=no, fullscreen=no, status=no, menubar=no, toolbar=no, resizable=no,');
	var form2 = document.addWordForm2;
	form2.action = 'addMyword.php';
	form2.method = 'post';
	form2.target = 'addWord';
	form2.submit();
}
</script>

<!-- Intro -->

<!-- 미리보기 부분이 다 flexbox로 되어있음. 보일 텍스트 개수를 제한해야함 -->
<!-- <section id="intro" class="container">
							<div class="row">
								<div class="col-4 col-12-medium">
									<section class="first">
										<i class="icon solid featured fa-cog"></i>
										<header>
											<h2>Dictionary</h2>
										</header>
										<p>사전, 번역기, 단어 퀴즈, 한줄회화..</p>
									</section>
								</div>
								<div class="col-4 col-12-medium">
									<section class="middle">
										<i class="icon solid featured alt fa-bolt"></i>
										<header>
											<h2>Blog, LiveChat</h2>
										</header>
										<p>Blog, LiveChat 소개</p>
									</section>
								</div>
								<div class="col-4 col-12-medium">
									<section class="last">
										<i class="icon solid featured alt2 fa-star"></i>
										<header>
											<h2>Media Library</h2>
										</header>
										<p>노래 영상, 영화 영상, 사진 등 미디어 소개</p>
									</section>
								</div>
							</div>

							<footer>
								<ul class="actions"> -->
<!-- 로그인된 상태면 메인화면과 연결. 비로그인이면 로그인화면으로 이동 -->
<!-- <li><a <?php
									if(isset($_SESSION['session_id']) && isset($_SESSION['session_name'])){ ?>
										href="index.php"
									<?php }else { ?>
										href="login.php"
									<?php } ?>
										class="button large">
										Get Started</a></li>
								</ul>
							</footer>

</section> -->

</section>

<!-- Main -->
<section id="main">
	<div class="container">
		<div class="row">
			<div class="col-12">


				<!-- Blog -->
				<section>
					<header class="major">
						<h2>The Blog</h2>
					</header>
					<div class="row">

						<div class="col-4 col-12-small">
							<section class="box">
								<a href="#" class="image featured"><img src="images/pic08.jpg" alt="" /></a>
								<header>
									<h3>블로그 테스트1</h3>
									<p>Posted 45 minutes ago</p>
								</header>
								<p>Lorem ipsum dolor sit amet sit veroeros sed et blandit consequat sed veroeros lorem et blandit adipiscing feugiat phasellus tempus hendrerit, tortor vitae mattis tempor, sapien sem feugiat sapien, id suscipit magna felis nec elit.
									Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos lorem ipsum dolor sit amet.</p>
								<footer>
									<ul class="actions">
										<li><a href="#" class="button icon solid fa-file-alt">Read More..</a></li>
										<li><a href="#" class="button alt icon solid fa-comment">33 comments</a></li>
									</ul>
								</footer>
							</section>
						</div>

						<div class="col-4 col-12-small">
							<section class="box">
								<a href="#" class="image featured"><img src="images/pic08.jpg" alt="" /></a>
								<header>
									<h3>블로그 테스트2</h3>
									<p>Posted 45 minutes ago</p>
								</header>
								<p>Lorem ipsum dolor sit amet sit veroeros sed et blandit consequat sed veroeros lorem et blandit adipiscing feugiat phasellus tempus hendrerit, tortor vitae mattis tempor, sapien sem feugiat sapien, id suscipit magna felis nec elit.
									Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos lorem ipsum dolor sit amet.</p>
								<footer>
									<ul class="actions">
										<li><a href="#" class="button icon solid fa-file-alt">Read More..</a></li>
										<li><a href="#" class="button alt icon solid fa-comment">33 comments</a></li>
									</ul>
								</footer>
							</section>
						</div>

						<div class="col-4 col-12-small">
							<section class="box">
								<a href="#" class="image featured"><img src="images/pic09.jpg" alt="" /></a>
								<header>
									<h3>블로그 테스트3</h3>
									<p>Posted 45 minutes ago</p>
								</header>
								<p>Lorem ipsum dolor sit amet sit veroeros sed et blandit consequat sed veroeros lorem et blandit adipiscing feugiat phasellus tempus hendrerit, tortor vitae mattis tempor, sapien sem feugiat sapien, id suscipit magna felis nec elit.
									Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos lorem ipsum dolor sit amet.</p>
								<footer>
									<ul class="actions">
										<li><a href="#" class="button icon solid fa-file-alt">Read More..</a></li>
										<li><a href="#" class="button alt icon solid fa-comment">33 comments</a></li>
									</ul>
								</footer>
							</section>
						</div>
					</div>
				</section>


				<!-- Media Library -->
				<section>
					<header class="major">
						<h2>Media Library</h2>
					</header>
					<div class="row">
						<div class="col-4 col-6-medium col-12-small">
							<section class="box">
								<a href="#" class="image featured"><img src="images/pic02.jpg" alt="" /></a>
								<header>
									<h3>음악 최신글</h3>
								</header>
								<p>findout more 누르면 글로 이동</p>
								<footer>
									<ul class="actions">
										<li><a href="#" class="button alt">Find out more</a></li>
									</ul>
								</footer>
							</section>
						</div>
						<div class="col-4 col-6-medium col-12-small">
							<section class="box">
								<a href="#" class="image featured"><img src="images/pic03.jpg" alt="" /></a>
								<header>
									<h3>영화&TV 최신글</h3>
								</header>
								<p>Lorem ipsum dolor sit amet sit veroeros sed amet blandit consequat veroeros lorem blandit adipiscing et feugiat phasellus tempus dolore ipsum lorem dolore.</p>
								<footer>
									<ul class="actions">
										<li><a href="#" class="button alt">Find out more</a></li>
									</ul>
								</footer>
							</section>
						</div>
						<div class="col-4 col-6-medium col-12-small">
							<section class="box">
								<a href="#" class="image featured"><img src="images/pic04.jpg" alt="" /></a>
								<header>
									<h3>기타 미디어 최신글</h3>
								</header>
								<p>Lorem ipsum dolor sit amet sit veroeros sed amet blandit consequat veroeros lorem blandit adipiscing et feugiat phasellus tempus dolore ipsum lorem dolore.</p>
								<footer>
									<ul class="actions">
										<li><a href="#" class="button alt">Find out more</a></li>
									</ul>
								</footer>
							</section>
						</div>

					</div>
				</section>

			</div>
			<div class="col-12">



			</div>
		</div>
	</div>
</section>



<!-- 하단 footer부분 bottom.php로 묶어서 불러오기 -->
<?php require('lib/bottom.php'); ?>
