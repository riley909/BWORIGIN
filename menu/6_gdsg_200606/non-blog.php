<?php require('lib/top.php'); ?>
</section>

			<!-- Main -->
				<section id="main">
					<div class="container">

						<?php
						header("Content-Type: text/html; charset=UTF-8");
						$conn = new mysqli("localhost", "studybahasa", "bahasa", "StudyBahasa");
						mysqli_query($conn, 'SET NAMES utf8');

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

						$sql = "SELECT *FROM blog";
						$res = $conn->query($sql);
						$totalpostnum = mysqli_num_rows($res); //총 게시물 수
						$totalpagenum = ceil($totalpostnum/4); //총 페이지수 = 총 게시물수/페이지당 게시글 수
						$totalblocknum = ceil($totalpagenum/5); //총 블록수 = 총 페이지수/한블록당 페이지수(블럭=아래페이지이동하는부분)
						$currentpagenum = (($page-1)*4); //현재페이지번호 = (페이지번호-1)*4

						// 한페이지당 출력될 부분
						$sql2 = "select *from blog order by postnum desc limit $currentpagenum, 4";
						$res2 = $conn->query($sql2);
						$num2 = (($page-1)*4)+1;
						?>


						<div class="col-9 col-12-medium imp-medium">

									<?php
									while($row = mysqli_fetch_array($res2)){
										$num = $row['postnum'];
										$title = str_replace(">", "&gt", str_replace("<", "&lt", $row['posttitle']));

										$content = $row['postcontent'];
										?>
							<!-- Content -->
							<article class="box post">
									<a href="#" class="image featured"><img src="images/pic01.jpg" alt="" style="padding:10px;"/></a>
									<div style="float:right; line-height:0.1em;">
										<p><?php echo $row['date'];?></p>
										<p>written by <?php echo $row['author'];?></p>
									</div>
									<header>
										<h2><?php echo $title; ?></h2>
									</header>
									<p>
											<?php echo nl2br($content); ?>
									</p>

									<div style="border-bottom:solid 1px #5d5d5d;">
									</div>
									<div style="float:right;">
										<table >
											<tr>
												<th><?php echo $row['hit']; ?></th>
												<th><?php echo "comment"; ?></th>

												<!-- 수정버튼 -->
												<?php if($_SESSION['session_name'] == $row['author']){?>
												<th><a href="/stdbhs/templ/postupdate.php?postnum='.$row['postnum'].'"style="ddisplay: inline-block; text-decoration: none; border-radius: 5px; background: #9eb86d; color: #fff; padding: 0.2em;">수정</a></th>
											<?php } ?>

											<!-- 삭제버튼 -->
											<?php if($_SESSION['session_name'] == $row['author']){?>
											<th><a href="/stdbhs/templ/postdelete.php?postnum='.$row['postnum'].'" style="ddisplay: inline-block; text-decoration: none; border-radius: 5px; background: #9eb86d; color: #fff; padding: 0.2em;">삭제</a></th>
										<?php } ?>

											</tr>
										</table>
									</div>

								</article>

							<?php } ?>



						<div style="display:-ms-flexbox; display:flex; -ms-flex-wrap:wrap; flex-wrap:wrap; margin-right:-15px; margin-left:-15px; -ms-flex-pack:center; justify-content:center; text-decoration:none; color:#779442">
								<?php
								$before = $pagination-1;
								$after = $pagination+1;
								$before2 = $before*5;
								$after2 = $after*5-4;

								if($pagination > 1){
									echo "<a href='/stdbhs/templ/non-blog.php?pagination=$before&page=$before2'>&laquo;</a>";
								}

								for($i = $pagination*5-4; $i <= $pagination*5; $i++){
									if($i <= $totalpagenum){
										echo "<a href='/stdbhs/templ/non-blog.php?pagination=$pagination&page=$i'>[$i]</a>";
									}else {
										break;
									}
								}

								if($pagination < $totalblocknum){
									echo "<a href='/stdbhs/templ/non-blog.php?pagination=$after&page=$after2'>&raquo;</a>";
								}
								 ?>
						</div>
					</div>

					</div>
				</div>
			</section>

			<?php require('lib/bottom.php'); ?>
