<!DOCTYPE html>
<html lang="kr">
  <head>
    <meta charset="utf-8">
    <title>글쓰기</title>
    <link rel="stylesheet" href="/stdbhs/bootstrap-4.4.1-dist/css/bootstrap.css">
  </head>
  <body>
    <?php header("Content-Type: text/html; charset=UTF-8");
session_start(); ?>

<?php
$conn = new mysqli("localhost", "studybahasa", "bahasa", "StudyBahasa");
mysqli_query($conn, 'SET NAMES utf8');

$postnum = $_GET['postnum'];
$sql = "SELECT *FROM blog WHERE postnum = '$postnum'";
$res = $conn->query($sql);
$row = mysqli_fetch_array($res);
 ?>

 <div>
 <form action="/stdbhs/templ/postingapply.php" method="post">
   <div class="form-group" style="margin:20px;">
     <input type="text" class="form-control" id="title" style="width:40%;" value="<?php echo $row['posttitle'];?>">
   </div>
   <div class="form-group" style="margin:20px;">
     <textarea class="form-control" id="content" style="width:40%; height:50%;" placeholder="Apa Anda belajar hari ini?"><?php echo str_replace('＆','&',$row['postcontent']); ?></textarea>
   </div>
   </form>
   
   <form action="/stdbhs/templ/postingapply.php" method="post">
   <div style="float:left;">
     <button class="btn btn-primary" onclick="apply()">게시글 등록</button>
     </div>
   </form>
 </div>

   <div id="demo"></div>





 <script>
 function apply() {
 var x1 = document.getElementById("title").value.replace("+","＋").replace(/#/g,"＃").replace(/&/g,"＆").replace(/=/g,"＝")
 	.replace(/\\/g,"＼");
 var x2 = document.getElementById("content").value.replace("+","＋").replace(/#/g,"＃").replace(/&/g,"＆").replace(/=/g,"＝")
 	.replace(/\\/g,"＼");
 var x3 = new Date();
 var days = ["일요일","월요일","화요일","수요일","목요일","금요일","토요일"];
 var time;
 time = x3.getFullYear()+"."+(x3.getMonth()+1)+"."+x3.getDate()+" "
 +days[x3.getDay()]+x3.getHours()+":"+x3.getMinutes();
 var obj, dbParam, xmlhttp, myObj, x;

 obj={"table":"blog","posttitle":x1,"postcontent":x2,"author":"<?php echo $_SESSION['session_name'] ?>",
 "date":time};

 dbParam = JSON.stringify(obj);
 xmlhttp = new XMLHttpRequest();
 xmlhttp.onreadystatechange = function() {

 if (this.readyState == 4 && this.status == 200) {

 myObj = JSON.parse(this.responseText);

 for (x in myObj) {

 if(myObj[x] == '1') {
   alert("포스팅이 완료되었습니다.");
 location.href='myblog.php';
 return false;

 } else {
 document.getElementById("demo").innerHTML = "업로드 실패!";
 }
 }
 }
 };
 if((x2.trim() == "<br>")||(x2.trim()=="")||(x1.trim() == "")) {
 alert("입력된 텍스트가 없습니다.");
 return false;
 } else {
 document.getElementById("content").innerHTML = "";
 xmlhttp.open("POST","postingapply.php",true);
 xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 xmlhttp.send("x=" + dbParam);
 }
 }
 </script>


</body>
</html>
