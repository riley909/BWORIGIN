<?php include_once 'menu.php'; ?>

<link href="https://unpkg.com/video.js/dist/video-js.css" rel="stylesheet">

<div class="container-fluid">
  <div class="row">
  <div class="col m-5">
    <video-js id="video" class="video-js vjs-live vjs-liveui" controls preload="auto" width="640" height="360" data-setup='{"liveui": true}'>
      <!-- <source src="rtmp://localhost:1935/vod&mp4:bye.mp4" type="rtmp/mp4"> -->
      <source src="rtmp://localhost:1935/live&cam" type="rtmp/flv">
      <!-- <source src="bye.mp4" type="video/mp4"> -->
    </video-js>
  </div>
  <div class="col offset-1">
    <input type="text" class="col-2" id="name" readonly></br>
    <textarea rows="20" cols="50" id="chatRoom"></textarea><br>
    <input type="text" class="col-7" id="chatInput">
    <input type="button" value="보내기" onclick="sendMsg()">

  </div>
  </div>
</div>

<script src="https://unpkg.com/video.js/dist/video.js"></script>
<script src="https://unpkg.com/videojs-flash/dist/videojs-flash.js"></script>

</body>

</html>