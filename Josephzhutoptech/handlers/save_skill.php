<?php
require_once '../config.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['is_admin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

try {
    // Get form data with default empty values
    $category = $_POST['category'] ?? '';
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';

    // Prepare SQL statement
    $stmt = $pdo->prepare("INSERT INTO skills (category, name, description) VALUES (?, ?, ?)");
    
    // Execute with parameters
    $result = $stmt->execute([$category, $name, $description]);
    
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Skill saved successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save skill']);
    }
} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} 