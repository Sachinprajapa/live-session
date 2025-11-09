<?php
require_once 'db.php';
$session = isset($_GET['session']) ? $_GET['session'] : '';

$stmt = $pdo->prepare("SELECT * FROM live_sessions WHERE unique_id = :id LIMIT 1");
$stmt->execute([':id' => $session]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$row) {
  die("Invalid session or session not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student View</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container">
    <header>
      <h1>Student Session</h1>
      <p>Session ID: <strong><?= htmlspecialchars($row['unique_id']) ?></strong></p>
    </header>

    <div class="video-section">
      <video id="player" controls>
        <source src="videos/sample.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
  </div>
</body>
</html>
