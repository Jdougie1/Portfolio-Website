<?php
header('Content-Type: application/json');

// Database credentials for InfinityFree
$host = 'sql112.infinityfree.com';
$dbname = 'if0_38883049_josephportfolio';
$username = 'if0_38883049';
$password = 'Personal321123';

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die(json_encode(['success' => false, 'message' => "Database connection failed: " . $e->getMessage()]));
}

function sendResponse($success, $data = null, $message = '') {
    echo json_encode([
        'success' => $success,
        'data' => $data,
        'message' => $message
    ]);
    exit;
}

function validateRequiredFields($fields, $data) {
    foreach ($fields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            sendResponse(false, null, "Missing required field: $field");
        }
    }
    return true;
} 