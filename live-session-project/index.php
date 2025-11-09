<?php
// index.php - Admin page
// Optionally you can add authentication here.
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$viewerPath = "/student.php"; // path to student viewer
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Admin - Start Session</title>
  <style>
    body{font-family: Arial, sans-serif;max-width:900px;margin:30px auto;padding:10px}
    button{padding:10px 18px;font-size:16px}
    .info{margin-top:16px;padding:12px;background:#f3f3f3;border-radius:6px}
    video{width:100%;max-height:540px;margin-top:12px;background:black}
    .link{word-break:break-all}
  </style>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <h2>Admin: Start Live Session</h2>
  <p>Click <strong>START SESSION</strong> to create a new session and show the video player.</p>
  <button id="startBtn">START SESSION</button>

  <div class="info" id="info" style="display:none;">
    <div><strong>Session ID:</strong> <span id="sessionId"></span></div>
    <div><strong>Student URL:</strong> <a id="studentLink" class="link" href="#" target="_blank"></a></div>
  </div>

  <!-- Video area -->
  <div id="videoArea" style="display:none;">
    <h3>Live Video</h3>
    <!-- Replace src with your own video file or streaming URL -->
    <video id="player" controls controlsList="nodownload" preload="metadata">
      <source id="videoSource" src="videos/sample.mp4" type="video/mp4">
      Your browser does not support the video tag.
    </video>
    <p style="font-size:13px;color:#666">Players have Play / Pause / Volume / Fullscreen controls (HTML5).</p>
  </div>

<script>
document.getElementById('startBtn').addEventListener('click', async function(){
  this.disabled = true;
  this.textContent = 'Creating...';

  try {
    const res = await fetch('create_session.php', {
      method: 'POST',
      headers: {'Content-Type':'application/json'},
      body: JSON.stringify({ type: 'admin' })
    });
    const data = await res.json();
    if(data.success){
      document.getElementById('info').style.display = 'block';
      document.getElementById('sessionId').textContent = data.unique_id;
      const link = data.userurl;
      const a = document.getElementById('studentLink');
      a.href = link;
      a.textContent = link;
      document.getElementById('videoArea').style.display = 'block';
      // If you want to set a different source returned from server:
      if(data.video_src){
        document.getElementById('videoSource').src = data.video_src;
        document.getElementById('player').load();
      }
    } else {
      alert('Error: ' + (data.message || 'Unknown'));
      this.disabled = false;
      this.textContent = 'START SESSION';
    }
  } catch(err) {
    alert('Request failed: ' + err);
    this.disabled = false;
    this.textContent = 'START SESSION';
  }
});
</script>

</body>
</html>
