<?php
header('Content-Type: application/json');
require_once 'db.php';

$input = json_decode(file_get_contents('php://input'), true);
$type = isset($input['type']) && $input['type'] === 'admin' ? 'admin' : 'student';

// generate unique id
function generate_unique_id($len=12){
    // hex + random bytes for collision resistance
    return bin2hex(random_bytes($len));
}

$unique_id = generate_unique_id(8);

// Build userurl. Adjust path if hosted in subfolder.
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$basePath = dirname($_SERVER['REQUEST_URI']);
$viewerPath = '/student.php'; // viewer page
$userurl = $protocol . '://' . $host . $viewerPath . '?session=' . $unique_id;

try {
    $stmt = $pdo->prepare("INSERT INTO live_sessions (type, unique_id, userurl) VALUES (:type, :unique_id, :userurl)");
    $stmt->execute([
        ':type' => $type,
        ':unique_id' => $unique_id,
        ':userurl' => $userurl
    ]);
    // optionally send a video source path (if you want dynamic)
    $video_src = 'videos/sample.mp4'; // change to your video path or streaming URL

    echo json_encode([
        'success' => true,
        'unique_id' => $unique_id,
        'userurl' => $userurl,
        'video_src' => $video_src
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success'=>false, 'message'=>$e->getMessage()]);
}
