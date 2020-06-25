<?php include_once '/var/www/html/menu/menu.php';
if(!isset($_SESSION['session_id'])){
  $sessionId = $_SESSION['session_id'];
  echo "<script>
   $.alert({
      icon: 'fas fa-exclamation-triangle',
      title: '',
      content: '로그인이 필요한 서비스입니다.',
      buttons: {
          confirm: function () {
              location.href = 'login.php';
          }
      }
  });  
  </script>";
  }else{
?>
<link href="https://unpkg.com/video.js/dist/video-js.css" rel="stylesheet">
<script src="http://localhost/html/node_modules/socket.io-client/dist/socket.io.js"></script>
<script src="http://localhost/html/node_modules/jquery/dist/jquery.js"></script>
<script src="http://localhost/html/webRTC/chat.js"></script>
<script src="https://unpkg.com/video.js/dist/video.js"></script>
<script src="https://unpkg.com/videojs-flash/dist/videojs-flash.js"></script>


<div class="container-fluid">
  <div class="row">
  <div class="col m-5">
    <video-js id="video" class="video-js vjs-live vjs-liveui" controls preload="auto" width="640" height="360" data-setup='{"liveui": true}'>
      <!-- <source src="rtmp://localhost:1935/vod&mp4:bye.mp4" type="rtmp/mp4"> -->
      <source src="rtmp://localhost:1935/live&cam" type="rtmp/flv">
    </video-js>
    <div class="mt-3">
      <!-- <button type="button" class="btn btn-info">후원하기</button> -->
    </div>
  </div>
  <div class="col-md-auto offset-2">
    <input type="text" id="name" readonly></br>
    <textarea rows="20" cols="40" id="chatRoom"></textarea><br>
    <input type="text" class="col-9" id="chatInput">
    <input type="button" class="btn btn-sm btn-info" value="보내기" onclick="sendMsg()">
  </div>
  <!-- 접속자 명단 -->
  <div class="col col-lg-2">
  <div id="userlist" class="bg-white" style="height: 400px; border:1px solid black;"></div>
  </div>
  </div>
</div>

</body>

</html>
<?php }?>