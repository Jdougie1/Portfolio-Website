<?php
require_once 'config.php';

try {
    $stmt = $pdo->query("SELECT * FROM experiences ORDER BY start_date DESC");
    $experiences = $stmt->fetchAll(PDO::FETCH_ASSOC);
    sendResponse(true, $experiences);
} catch (PDOException $e) {
    sendResponse(false, null, "Database error: " . $e->getMessage());
} 