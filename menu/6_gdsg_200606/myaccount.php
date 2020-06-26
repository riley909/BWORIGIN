<?php require('lib/top.php');

// 세션있으면 페이지 접속가능
if($_SESSION['session_id']){ ?>

<style>
	.btn-primary1 {
		color: #fff;
		background-color: #9eb86d;
		border-color: #9eb86d;
	}

	.btn-primary1:hover {
		color: #fff;
		background-color: #c2d1a4;
		border-color: #c2d1a4;
	}

	.btn-primary11:focus,
	.btn-primary1.focus {
		color: #fff;
		background-color: #c2d1a4;
		border-color: #c2d1a4;
		box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
	}

	.btn-primary1.disabled,
	.btn-primary1:disabled {
		color: #fff;
		background-color: #c2d1a4;
		border-color: #c2d1a4;
	}

	.btn-primary1:not(:disabled):not(.disabled):active,
	.btn-primary1:not(:disabled):not(.disabled).active,
	.show>.btn-primary1.dropdown-toggle {
		color: #fff;
		background-color: #779442;
		border-color: #779442;
	}

	.btn-primary1:not(:disabled):not(.disabled):active:focus,
	.btn-primary1:not(:disabled):not(.disabled).active:focus,
	.show>.btn-primary1.dropdown-toggle:focus {
		box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
	}
</style>


</section>

<?php
header("Content-Type: text/html; charset=UTF-8");
$conn = new mysqli("localhost", "studybahasa", "bahasa", "StudyBahasa");
mysqli_query($conn, 'SET NAMES utf8');
$sessionID = $_SESSION['session_id'];
$sql = "SELECT *FROM member WHERE id='$sessionID'";
$res = $conn->query($sql);
$row = mysqli_fetch_array($res);

if($res -> num_rows > 0){
	$id = $row['id'];
	$name = $row['name'];
	$phonenum = $row['phonenum'];

// @기준으로 이전문자 반환
	$id1 = strstr($id, "@", true);
	// @기준 이후 문자 반환
	$id2 = strstr($id, "@");

	// 앞자리가 3글자 미만이면 뒤에서부터 2글자 치환
	if(strlen($id1) <= 3){
		$idPart = substr($id1, 0, -2)."**";
		$idFinal = $idPart.$id2;
	}else if(strlen($id1) < 4){
		$idPart = substr($id1, 0, -3)."***";
		$idFinal = $idPart.$id2;
	}else{
		// 뒤에서부터 4자리 문자 치환
		$idPart = substr($id1, 0, -4)."****";
		$idFinal = $idPart.$id2;
	}


// 유저 실명 길이를 구해서 3글자 이상이면 2글자를 보여주고 미만이면 1글자만 노출
	$nameLength = mb_strlen($name, 'utf-8');
	if($nameLength > 2){
		$nameFinal = mb_substr($name, 0, 2, 'utf-8')."*";
	}else{
		$nameFinal = mb_substr($name, 0, 1, 'utf-8')."*";
	}

	$phoneFinal = substr($phonenum, 0, -4)."****";

	?>



<!-- Main -->
<section id="main">
	<div class="container justify-content-center" style="display:flex;">

		<!-- Content -->
		<div style="text-align:center;">
			<article class="box post" style="display:inline-block; margin-right:10px; padding-top:1em; padding-bottom:0.1em; width:350px; height:330px;">
				<header>
					<div style="text-align:left; margin-left:20px;">
						<h3>블로그 프로필</h3>
					</div>
				</header>
				<div style="display:flex;">
					<div style="width:90px; height:90px; border-radius:50%; position:relative;">
						<a style="position:absolute; top:50%; left:50%; -ms-transform:translate(-50%, -50%); transform:translate(-50%, -50%);" href="modprofile.php">
							<?php
											// status가 0인지 1인지 조회
			                $sqlImg = "SELECT *FROM profilepic WHERE id='$id'";
			                $resImg = mysqli_query($conn, $sqlImg);
			                $rowImg = mysqli_fetch_assoc($resImg);
											$loadedPic = $row['pic_name_saved'];
                      $loadedOriName = $row['pic_name_ori'];
											if($rowImg['status'] == 0){
												echo "<img style='border-radius:50%;' src='upload/user.png' height='90' width='90'>";
											}else {
												echo "<img style='border-radius:50%;' src=".$loadedPic." height=90px; width=90px; alt='".$loadedOriName."'>";
											}
											?>

						</a>
					</div>
					<p style="margin-top:40px; margin-left:30px;">별명</p>
					<h4 style="margin-top:36px; margin-left:30px;"><?php echo $_SESSION['session_name'];?></h4>
				</div>

				<!-- 프로필 수정버튼 -->
				<section>
					<header style="float:left; padding-top:70px;">
						<a class="btn btn-primary1" href="modprofile.php">수정</a>
					</header>
			</article>
		</div>

		<div style="float:left;">
			<article class="box post" style="display:inline-block; margin-left:10px; padding-top:1em; padding-bottom:0.1em; width:350px; height:330px;">
				<header>
					<div style="text-align:left; margin-left:20px;">
						<h3>개인 정보</h3>
					</div>
				</header>
				<p>이메일 &emsp;&nbsp;&nbsp; <?php echo $idFinal;?><br>
					이름 &emsp;&emsp;&nbsp;&nbsp; <?php echo $nameFinal;?><br>

					<!-- 개인정보 수정버튼 -->
					<section>
						<header style="padding-top:73px;">
							<a class="btn btn-primary1" href="modpersonalinfo.php" data-toggle="modal" data-target="#pwdReCheckModal">수정</a>
						</header>

						<!-- Modal -->
						<div class="modal fade" id="pwdReCheckModal" tabindex="-1" role="dialog" aria-labelledby="pwdReCheckModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="pwdReCheckModalLabel">비밀번호 재확인</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form action="modpersonalinfo.php" method="post">
										<div class="modal-body">
											<label>비밀번호를 입력하세요</label>
											<input class="form-control" type="password" name="pwdReCheck" required>
										</div>
										<div class="modal-footer">
											<button type="submit" class="btn btn-primary1">확인</button>
											<button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
										</div>
									</form>
								</div>
							</div>
						</div>
			</article>
		</div>

	</div>
</section>

<!-- sql문 종료 -->
<?php } ?>

<!-- 비로그인 접속제한 -->
<?php }else { ?>
<script>
	alert("로그인이 필요한 서비스 입니다.")
	location.replace('index.php')
</script>
<?php } ?>

<?php require('lib/bottom.php'); ?>
