<?php
require_once 'config.php';

try {
    $stmt = $pdo->query("SELECT * FROM personal_info ORDER BY id DESC LIMIT 1");
    $info = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($info) {
        sendResponse(true, $info);
    } else {
        sendResponse(false, null, "No personal information found");
    }
} catch (PDOException $e) {
    sendResponse(false, null, "Database error: " . $e->getMessage());
} 