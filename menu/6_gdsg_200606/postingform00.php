<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
?>

<script>
var getCookie = function(name){
  var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
// 삼항연산자 value가 있다면 value[2](2가 뭐야)를 리턴하고 아니면 null리턴
  return value? value[2] : null;
};
console.log(getCookie("temp_title"));
console.log(getCookie("temp_content"));
</script>

<!DOCTYPE html>
<html lang="kr">
  <head>
    <meta charset="utf-8">
    <title>글쓰기</title>
    <link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="summernote/summernote-lite.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="summernote/js/summernote-lite.js"></script>
    <script src="summernote/js/lang/summernote-ko-KR.js"></script>
  </head>
  <body>
    <?php header("Content-Type: text/html; charset=UTF-8");
session_start(); ?>

<!-- 쿠키불러오기 선택창 띄운다 -->
<script>
if(getCookie("temp_title") || getCookie("temp_content")){
  var cookieConfirm = confirm("임시저장된 글이 존재합니다.\n 저장된 글을 불러올까요?");
}
</script>

<div style="">
<form action="/stdbhs/templ/postingapply.php" method="post">
  <div class="form-group" style="margin:20px;">
    <input type="text" class="form-control" id="title" style="width:40%;">
    <!-- js에서 아이디값을 변수로 받고 변수값을 쿠키값으로 바꿔준다 -->
    <!-- confirm창에서 확인을 눌렀을 때만 쿠키값 세팅 -->
    <script>
    if(cookieConfirm){
      var temp_title = document.getElementById("title");
      temp_title.value = getCookie("temp_title");
    }
    </script>
  </div>
  <div class="form-group" style="margin:20px;">
    <textarea class="form-control" id="content" style="width:40%; height:50%;" placeholder="Apa Anda belajar hari ini?"></textarea>
    <!-- js에서 아이디값을 변수로 받고 변수값을 쿠키값으로 바꿔준다 -->
    <script>
    if(cookieConfirm){
      var temp_content = document.getElementById("content");
      temp_content.value = getCookie("temp_content");
    }
    </script>
  </div>
  </form>
  <div style="float:left; margin-right:10px;">
    <button class="btn btn-primary" onclick="tempSave()">임시 저장</button>
  </div>

  <form action="/stdbhs/templ/postingapply.php" method="post">
  <div style="float:left;">
    <button class="btn btn-primary" onclick="apply()">게시글 등록</button>
    </div>
  </form>
</div>

  <div id="demo"></div>





<script>
function tempSave(){
// html에서 입력받은것을 js변수에 넣음
  var temp_title = document.getElementById("title").value;
  var temp_content = document.getElementById("content").value;
// 쿠키생성 함수
  function setCookie(name, value, exp){
    var date = new Date();
    date.setTime(date.getTime() + exp*60*1000);
    document.cookie = name + "=" + value + ';expires=' + date.toUTCString() + ';path=/';
  };
  //타이틀과 내용을 쿠키로 만든다
  setCookie("temp_title", temp_title, 1);
  setCookie("temp_content", temp_content, 1);

}

</script>


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
"date":time, "authorid":"<?php echo $_SESSION['session_id']?>"};

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
