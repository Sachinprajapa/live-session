<?php
// DB configuration - अपनी values यहाँ डालें
$DB_HOST = 'localhost';
$DB_NAME = 'live_sessions_db';
$DB_USER = 'root';
$DB_PASS = '';

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo "DB Connection error: " . $e->getMessage();
    exit;
}
