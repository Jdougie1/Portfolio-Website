<?php
require_once 'config.php';

try {
    $stmt = $pdo->query("SELECT * FROM skills ORDER BY category, name");
    $skills = $stmt->fetchAll(PDO::FETCH_ASSOC);
    sendResponse(true, $skills);
} catch (PDOException $e) {
    sendResponse(false, null, "Database error: " . $e->getMessage());
} 