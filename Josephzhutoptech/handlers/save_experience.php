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
    $title = $_POST['title'] ?? '';
    $company = $_POST['company'] ?? '';
    $start_date = $_POST['start_date'] ?? null;
    $end_date = $_POST['end_date'] ?: null;
    $description = $_POST['description'] ?? '';

    // Prepare SQL statement
    $stmt = $pdo->prepare("INSERT INTO experiences (title, company, start_date, end_date, description) VALUES (?, ?, ?, ?, ?)");
    
    // Execute with parameters
    $result = $stmt->execute([$title, $company, $start_date, $end_date, $description]);
    
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Experience saved successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save experience']);
    }
} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} 