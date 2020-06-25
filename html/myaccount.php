<?php 
include_once '/var/www/html/menu/menu.php';
require '/var/www/html/menu/db.php';
// 세션있으면 페이지 접속가능
if($_SESSION['session_id']){ 
    $sessionId = $_SESSION['session_id'];

    // DB에서 세션아이디값과 일치하는 데이터를 불러온다
    $sql = queryResult("SELECT *FROM user WHERE id='$sessionId'");
    $row = mysqli_fetch_array($sql);
    if($sql->num_rows > 0){
        $id = $row['id'];
        $email = $row['email'];
        
        if($row['birthyear'] != 0){
            $birthYear = $row['birthyear'];
        }else{
            $birthYear = "";
        }
        if($row['gender'] == 1){
            $gender = "남";
        }else if($row['gender'] == 2){
            $gender = "여";
        }else{
            $gender = "";
        }

        // 이메일 주소가 바로 보이지 않게 별표로 치환한다
        // @기준으로 이전문자 반환
        $emailFormer = strstr($email, "@", true);
        // @기준 이후 문자 반환
        $emailLatter = strstr($email, "@");

        // 앞자리가 3글자 미만이면 뒤에서부터 2글자 치환
        if(strlen($emailFormer) <= 3){
            $emailPart = substr($emailFormer, 0, -2)."**";
            $emailFinal = $emailPart.$emailLatter;
        }else if(strlen($emailFormer) < 4){
            $emailPart = substr($emailFormer, 0, -3)."***";
            $emailFinal = $emailPart.$emailLatter;
        }else{
            // 뒤에서부터 4자리 문자 치환
            $emailPart = substr($emailFormer, 0, -4)."****";
            $emailFinal = $emailPart.$emailLatter;
        }
        ?>

<main class="dash-content">
    <div class="container-fluid">
        <div class="row">
            <div class="dash-content">
                <div class="content-fluid">
                    <div class="col-xl-6">
                        <div class="card easion-card">
                            <div class="card-header">
                                <div class="easion-card-icon">
                                    <i class="fas fa-user-cog"></i>
                                </div>
                                <div class="easion-card-title">
                                    내 정보
                                </div>
                            </div>
                            <div class="card-body ">
                                <table class="table table-in-card">
                                    <thead>
										<!-- 프로필 사진 위치 -->
                                    <?php
										// status가 0인지 1인지 조회
										$sqlImg = queryResult("SELECT *FROM profilepic WHERE id='$id'");
										$rowImg = mysqli_fetch_assoc($sqlImg);
										$loadedPic = $row['pic_name_saved'];
										$loadedOriName = $row['pic_name_ori'];
											if($rowImg['status'] == 0){
												echo "<img style='border-radius:50%;' src='upload/user.png' height='90' width='90'>";
											}else {
												echo "<img style='border-radius:50%;' src=".$loadedPic." 
												height=90px; width=90px; alt='".$loadedOriName."'>";
											} ?>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">아이디</th>
                                            <td><?=$id?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">이메일</th>
                                            <td><?=$emailFinal?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">출생년도</th>
                                            <td><?=$birthYear?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">성별</th>
                                            <td><?=$gender?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

							<!-- 개인정보 수정버튼 -->
							<!-- 수정하기 전 비밀번호를 재확인하는 모달창이 뜬다 -->
                            <header style="display:flex; justify-content:center;">
                                <a
                                    class="btn btn-info mt-2 mb-4"
                                    href="modpersonalinfo.php"
                                    data-toggle="modal"
                                    data-target="#pwdReCheckModal">수정</a>
                            </header>

							<!-- Modal -->
							<!-- tabindex=키보드 탭 키를 눌렀을 때 포커스 이동을 설정할 수 있다 -->
							<!-- tabindex가 음수일때는 링크나 버튼같은 포커스를 받을수 있는 요소도 받을 수 없게 한다. -->
                            <div
                                class="modal fade"
								id="pwdReCheckModal"
                                tabindex="-1"
                                role="dialog"
                                aria-labelledby="pwdReCheckModalLabel"
                                aria-hidden="true">
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
                                                <input
                                                    class="form-control"
                                                    type="password"
                                                    name="pwdReCheck"
                                                    required="required">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info">확인</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- sql문 종료 -->
            <?php } ?>

            <!-- 비로그인 접속제한 -->
        <?php }else { ?>
            <script>
                alert("로그인이 필요한 서비스 입니다.")
                location.replace('index.php')
            </script>

            <?php } ?>

        </script>
        <script
            src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
        <script
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
        <script src="../js/easion.js"></script>
   
<?php include_once '/var/www/html/menu/bottom.html';?>