<?php
require_once 'config.php';

try {
    $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    sendResponse(true, $projects);
} catch (PDOException $e) {
    sendResponse(false, null, "Database error: " . $e->getMessage());
} 