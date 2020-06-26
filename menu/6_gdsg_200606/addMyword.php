<?php
header("Content-Type: text/html; charset=UTF-8");
session_start();
error_reporting(E_ALL);
ini_set('display_errors','1');

if(isset($_SESSION['session_id'])){
  $id = $_SESSION['session_id'];
  ?>

<!DOCTYPE html>
<html lang="kr" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>단어장 저장</title>
  <link rel="stylesheet" href="assets/css/main.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
  <div style="position:relative; height:299px;">
    <div class="" style="width: 18rem;">
      <div class="card-body">
        <div style="text-align:center;">
          <h6 class="card-title">단어장 저장</h6>
        </div>

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

        .btn-primary11:focus, .btn-primary1.focus {
          color: #fff;
          background-color: #c2d1a4;
          border-color: #c2d1a4;
          box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
        }

        .btn-primary1.disabled, .btn-primary1:disabled {
          color: #fff;
          background-color: #c2d1a4;
          border-color: #c2d1a4;
        }

        .btn-primary1:not(:disabled):not(.disabled):active, .btn-primary1:not(:disabled):not(.disabled).active,
        .show > .btn-primary1.dropdown-toggle {
          color: #fff;
          background-color: #779442;
          border-color: #779442;
        }

        .btn-primary1:not(:disabled):not(.disabled):active:focus, .btn-primary1:not(:disabled):not(.disabled).active:focus,
        .show > .btn-primary1.dropdown-toggle:focus {
          box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
        }
        </style>

        <?php
        header("Content-Type: text/html; charset=UTF-8");
        $conn = new mysqli("localhost", "studybahasa", "bahasa", "StudyBahasa");
        mysqli_query($conn, 'SET NAMES utf8');


        // if(isset($_POST['wordid']) || isset($_POST['folderlist'])){
          if(isset($_POST['wordid'])){
            $wordid = $_POST['wordid'];
            print_r($wordid);
          }
          if(isset($_POST['arrayLength'])){
            $arrayLength = $_POST['arrayLength'];
            echo $arrayLength;
          }

        ?>
        <a href="#" class="text-muted" style="font-size:13px; text-decoration:none;" data-toggle="modal" data-target="#addNewFolderModal" data-wordid="<?= $wordid;?>">＋ 새폴더 추가</a><hr>

        <!-- Modal -->
        <div class="modal fade" id="addNewFolderModal" tabindex="-1" role="dialog" aria-labelledby="addNewFolderLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addNewFolderLabel">새 폴더 추가</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="addMyword.php" method="post" name="modalForm">
                <div class="modal-body">
                  <label>폴더 이름을 입력하세요</label>
                  <input class="form-control" type="text" name="folderName" required>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary1" onclick="submitWordIdBack()">확인</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <script>
        $('#addNewFolderModal').on('show.bs.modal', function(e){
          var wordid = $(e.relatedTarget).data('wordid');
          console.log("11");
        });

        function submitWordIdBack(){
					var form = document.modalForm;
					form.action = 'addMyword.php';
					form.method = 'post';

          var input = document.createElement('input');
          input.setAttribute('type', 'hidden');
          input.setAttribute('name', 'wordid');
          input.setAttribute('value', wordid);

          form.appendChild(input);
          document.body.appendChild(form);
          console.log("111");
				}
				</script>

        <?php
        // 폴더이름 db추가
        if(isset($_POST['folderName'])){
          $folderName = $_POST['folderName'];
          $folderlistsql = "INSERT INTO mywordfolderlist (id, foldername, foldernum) VALUES ('$id', '$folderName', null)";
          $folderlistres = $conn->query($folderlistsql);
        }

        // 폴더목록 불러오기
        $foldersql = "SELECT *FROM mywordfolderlist";
        $folderres = $conn->query($foldersql);
        if($folderres -> num_rows > 0){
          while ($folderrow = mysqli_fetch_assoc($folderres)) { ?>
            <form action="" method="post">
            <div class="input-group">
              <input type="radio" name="folderlist" value="<?= $folderrow['foldername'];?>" style="-webkit-appearance:radio;">
              &ensp;<?= $folderrow['foldername'];?>
            </div><hr>
        <?php  }
        } ?>

      </div>
    </div>
    <input type="hidden" name="savedWordid" value="<?= $wordid;?>">
    <button class="col-sm-12" style="background-color:#d1d1d1; position:absolute; bottom:0px; border: solid 1px #d1d1d1;">저장</button>
  </div>
  </form>

  <?php
  // 라디오버튼으로 폴더이름 지정후 저장 눌러서 넘어온 데이터
  if(isset($_POST['folderlist'])){
    $folderlist = $_POST['folderlist'];
    $savedWordid = $_POST['savedWordid'];
    // mywordfolderlist에서 foldernum을 가져온다
    $sqlFolderNum = "SELECT * FROM mywordfolderlist WHERE foldername='$folderlist'";
    $resFolderNum = $conn->query($sqlFolderNum);
    $rowFolderNum = mysqli_fetch_assoc($resFolderNum);
    if($resFolderNum -> num_rows > 0){
      $folderNum = $rowFolderNum['foldernum'];
    }

    // 중복된 단어인지 체크
    $sqlCheck = "SELECT * FROM myword WHERE id='$id' AND foldernum='$folderNum' AND wordid='$savedWordid'";
    $resCheck = $conn->query($sqlCheck);
    $rowCheck = mysqli_fetch_array($resCheck);
    if($resCheck -> num_rows == 0){
      $sqlSaveWord = "INSERT INTO myword (id, foldernum, wordid) VALUES ('$id', '$folderNum', '$savedWordid')";
      $resSaveWord = $conn->query($sqlSaveWord);

      $sqlSaveCheck = "SELECT * FROM myword WHERE id='$id' and foldernum='$folderNum' and wordid='$savedWordid'";
      $resSaveCheck = $conn->query($sqlSaveCheck);
      if($resSaveCheck -> num_rows > 0){
        echo "<script>alert('단어가 저장되었습니다.');</script>";
      }
    }else{
      echo "<script>alert('이미 저장된 단어입니다.');</script>";
    }
    echo "<script>window.close();</script>";

  }
   ?>

<?php
// isset get['wordid'] 종료
 // }

 // 세션이 없으면
}else{ ?>
<script>
 alert("로그인이 필요한 서비스 입니다.")
 location.replace('index.php')
</script>

<?php } ?>

</body>

</html>
