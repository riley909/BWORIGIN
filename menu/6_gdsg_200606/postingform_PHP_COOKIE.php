


<!DOCTYPE html>
<html lang="kr">
  <head>
    <meta charset="utf-8">
    <title>글쓰기</title>
  </head>
  <body>
    <?php header("Content-Type: text/html; charset=UTF-8");
session_start(); ?>

<textarea id="title" rows="1" cols="70"></textarea>
<div style="border:1px solid; height:400px; overflow:auto;" id="editor" contentEditable="true"></div>
<div id="demo"></div>
<form method="get">
  <input type="submit" name="save_temp" value="임시저장">
</form>
<button style="border:1px solid;" onclick="apply()">게시글 등록</button>

<?php
$temp_title = 'echo "<script>document.getElementById("title").value;</script>"';
$temp_content = 'echo "<script>document.getElementById("editor").value;</script>"';
function save_temp(){
  setcookie('temp_title', $temp_title, time()+60);
  setcookie('temp_content', $temp_content, time()+60);
}
if(array_key_exists('save_temp', $_GET)){
  save_temp();
}
 ?>



<script>
function apply() {
var x1 = document.getElementById("title").value.replace("+","＋").replace(/#/g,"＃").replace(/&/g,"＆").replace(/=/g,"＝")
	.replace(/\\/g,"＼");
var x2 = document.getElementById("editor").innerHTML.replace("+","＋").replace(/#/g,"＃").replace(/&/g,"＆").replace(/=/g,"＝")
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
document.getElementById("editor").innerHTML = "";
xmlhttp.open("POST","postingapply.php",true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send("x=" + dbParam);
}
}
</script>
   </body>
 </html>
