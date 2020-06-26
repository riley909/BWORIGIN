<?php require('lib/top.php'); ?>


</section>

<!-- Main -->
<section id="main">
	<div class="container">
		<div class="row">
			<div class="col-8 col-12-medium">



				<!-- Content -->
				<section>
					<!-- action을 비워놓아야 자신을 가리킨다 -->
					<form action="<?=$PHP_SELF?>" method="get">
						<div class="input-group pl-0 justify-content-center" style="">
							<h3 style="margin-right:20px;">KAMUS</h3>
							<!-- required= boolean attribute. it specified that an input field must be filled out before submitting the form -->
							<input class="form-control my-0 py-1 col-sm-8" type="text" placeholder="Search.." name="search" required autofocus>

							<div class="input-group-append">
								<button class="input-group-text" type="submit"><i class="fas fa-search text-grey" aria-hidden="true"></i></button>
							</div>
						</div>
					</form>
				</section>

				<?php
				header("Content-Type: text/html; charset=UTF-8");
				$conn = new mysqli("localhost", "studybahasa", "bahasa", "StudyBahasa");
				mysqli_query($conn, 'SET NAMES utf8');

				$search = $_GET['search'];

				// get으로 page 받은것있으면 받은값을 변수page에 저장. 없으면 변수page는 1
				if(isset($_GET['page'])){
					$page = $_GET['page'];
				}else {
					$page = 1;
				}

				if(isset($_GET['pagination'])){
					$pagination = $_GET['pagination'];
				}else {
					$pagination = 1;
				}

				$sql = "SELECT *FROM dictionary WHERE indonesian LIKE '$search%' OR
				korean LIKE '$search%'";
				$res = $conn->query($sql);

				$totalpostnum = mysqli_num_rows($res); //총 게시물 수
				// ceil=소수점 받아올림 함수.
				$totalpagenum = ceil($totalpostnum/4); //총 페이지수 = 총 게시물수/페이지당 게시글 수
				$totalblocknum = ceil($totalpagenum/5); //총 블록수 = 총 페이지수/한블록당 페이지수(블럭=아래페이지이동하는부분)
				$currentpagenum = (($page-1)*4); //현재페이지번호 = (페이지번호-1)*4

				// 한페이지당 출력될 부분
				$sql2 = "SELECT *FROM dictionary WHERE indonesian LIKE '$search%' OR
				korean LIKE '$search%' limit $currentpagenum, 4";
				$res2 = $conn->query($sql2);

				// 게시물 앞에붙을 번호(안써도됨)
				$num2 = (($page-1)*4)+1;
				?>

				<?php
				// get으로 받은 search가 있는지 검사
				if(isset($_GET['search'])){?>

					<?php
					// 사전db while문 시작
					$counter = 0;
					$arrayLength;

				 while ($row = mysqli_fetch_array($res2)) {
					 global $arrayLength;
					 $arrayLength = mysqli_num_rows($res2);
					 $indonesian = $row['indonesian'];
					 $korean = $row['korean'];
					 $english = $row['english'];
					 $wordid = $row['wordid'];
				 ?>

				 <form action="" method="post" name="addWordForm">
				<article class="box post">
					<header>
							<!-- 세션아이디가 있으면 단어추가 버튼을 보여준다 -->
								<?php
								if(isset($_SESSION['session_id'])){ ?>
									<div>
										<button id="myWordBtn" type="button" class="btn btn-primary1" style="float:right; margin-top:-30px;" onclick="submitWord()"><i class="fas fa-plus" aria-hidden="true"></i></button>
									</div>
								<?php } ?>
							<h3><?php echo $indonesian;?></h3><hr>
							<p><?php echo $korean;?></p>
						</header>
						<p><?php echo $english;?></p>
						<p><?php echo $wordid;?></p>
						<p><?php echo $arrayLength;?></p>
						<input type="hidden" name="wordid[]" value="<?= $wordid;?>">
						<!-- <input type="hidden" name="<?= $counter;?>" value="<?= $counter;?>"> -->
					</article>

					<!-- 사전db while문 끝 -->
				<?php  $counter++;} ?>
				<input type="hidden" name="arrayLength" value="<?= $arrayLength;?>">
				</form>

				<script>
				function submitWord(){
					window.open('addMyword.php', 'addWord', 'top=350, left=1180, width=300px, height=300px, location=no, fullscreen=no, status=no, menubar=no, toolbar=no, resizable=no,');
					var form = document.addWordForm;
					form.action = 'addMyword.php';
					form.method = 'post';
					form.target = 'addWord';
					form.submit();
				}
				</script>

			<!-- 페이징 출력부분 -->
			<div style="display:-ms-flexbox; display:flex; -ms-flex-wrap:wrap; flex-wrap:wrap; margin-right:-15px; margin-left:-15px; -ms-flex-pack:center; justify-content:center;">
					<?php
					$before = $pagination-1;
					$after = $pagination+1;
					$before2 = $before*5;
					$after2 = $after*5-4;

					if($pagination > 1){
						echo "<a href='/stdbhs/templ/kamus.php?search=$search&pagination=$before&page=$before2'>&laquo;</a>";
					}

					for($i = $pagination*5-4; $i <= $pagination*5; $i++){
						if($i <= $totalpagenum){
							echo "<a href='/stdbhs/templ/kamus.php?search=$search&pagination=$pagination&page=$i'>[$i]</a>";
						}else {
							break;
						}
					}

					if($pagination < $totalblocknum){
						echo "<a href='/stdbhs/templ/kamus.php?search=$search&pagination=$after&page=$after2'>&raquo;</a>";
					}
					 ?>
			</div>

			<!-- get['search']가 없으면 -->
		<?php }else { ?>
			<article class="box post" style="text-align:center;">
				<header>
					<p>Anda ingin tahu kosakata apa?</p>
				</header>
				<p>어떤 단어가 궁금하세요?</p>
			</article>

		<?php } ?>


			</div>
			<div class="col-4 col-12-medium">
				<!-- Sidebar -->
				<section class="box" style="padding-bottom:20px;">
					<header>
						<h4>내가 찾은 단어</h4>
					</header>
					<p>검색<br>기록<br></p>
					<hr>
					<footer>
						<a href="#" class="button alt">내 단어장 가기</a>
					</footer>
				</section>

				<!-- 추천단어 불러오기 -->
				<?php
				$sqlHourly1 = "SELECT * FROM rand_word WHERE type='hourly1'";
				$resHourly1 = $conn->query($sqlHourly1);
				$rowHourly1 = mysqli_fetch_assoc($resHourly1);
				if($resHourly1 -> num_rows > 0){
					$indonesian1 = $rowHourly1['indonesian'];
					$korean1 = $rowHourly1['korean'];
					$english1 = $rowHourly1['english'];
					$wordid1 = $rowHourly1['wordid'];
				}

				$sqlHourly2 = "SELECT * FROM rand_word WHERE type='hourly2'";
				$resHourly2 = $conn->query($sqlHourly2);
				$rowHourly2 = mysqli_fetch_assoc($resHourly2);
				if($resHourly2 -> num_rows > 0){
					$indonesian2 = $rowHourly2['indonesian'];
					$korean2 = $rowHourly2['korean'];
					$english2 = $rowHourly2['english'];
					$wordid2 = $rowHourly2['wordid'];
				}
				?>
				<section class="box" style="padding-bottom:10px;">
					<header>
						<h4>추천 단어</h4>
					</header>
					<p style="font-size:13px;">이 단어를 알고 계신가요?</p>
					<hr>
					<div class="justify-content-center" style="display:flex; width:100%; text-align:center;">
						<form action="addMyword.php" method="post" name="addWordForm1">
						<div style="">
							<?php
							if(isset($_SESSION['session_id'])){ ?>
								<div>
									<button id="myWordBtn" type="button" class="btn btn-primary1" style="float:right; padding:0em 0.3em 0em 0.3em;" onclick="submitWord1()"><i class="fas fa-plus" aria-hidden="true"></i></button>
								</div>
							<?php } ?>
							<h5><?= $indonesian1;?></h5>
							<p style="font-size:12px;"><?= $korean1;?></p>
							<p style="font-size:12px;"><?= $english1;?></p>
							<input type="hidden" name="wordid" value="<?= $wordid1;?>">
						</div>
						</form>

						<script>
						function submitWord1(){
							window.open('addMyword.php', 'addWord', 'top=350, left=1180, width=300px, height=300px, location=no, fullscreen=no, status=no, menubar=no, toolbar=no, resizable=no,');
							var form1 = document.addWordForm1;
							form1.action = 'addMyword.php';
							form1.method = 'post';
							form1.target = 'addWord';
							form1.submit();
						}
						</script>

						<!-- 중간선 -->
						<div class="" style="top:0; bottom:0; width:1px; background-color:#dadada; margin-right:20px; margin-left:20px;"></div>

						<form action="addMyword.php" method="post" name="addWordForm2">
						<div style="">
							<?php
							if(isset($_SESSION['session_id'])){ ?>
								<div>
									<button id="myWordBtn" type="button" class="btn btn-primary1" style="float:right; padding:0em 0.3em 0em 0.3em;" onclick="submitWord2()"><i class="fas fa-plus" aria-hidden="true"></i></button>
								</div>
							<?php } ?>
							<h5><?= $indonesian2;?></h5>
							<p style="font-size:12px;"><?= $korean2;?></p>
							<p style="font-size:12px;"><?= $english2;?></p>
							<input type="hidden" name="wordid" value="<?= $wordid2;?>">
						</div>
					</form>

					<script>
					function submitWord2(){
						window.open('addMyword.php', 'addWord', 'top=350, left=1180, width=300px, height=300px, location=no, fullscreen=no, status=no, menubar=no, toolbar=no, resizable=no,');
						var form2 = document.addWordForm2;
						form2.action = 'addMyword.php';
						form2.method = 'post';
						form2.target = 'addWord';
						form2.submit();
					}
					</script>

					</div>
					<!-- <footer>
					</footer> -->
				</section>

			</div>
		</div>
	</div>
</section>

<?php require('lib/bottom.php'); ?>
