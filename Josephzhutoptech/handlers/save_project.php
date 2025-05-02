<?php
require_once '../config.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['is_admin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Debug: Log the incoming data
error_log("Received POST data: " . print_r($_POST, true));

try {
    // Get form data with default empty values
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $github_url = $_POST['github_url'] ?? null;
    $demo_url = $_POST['demo_url'] ?? null;
    $start_date = $_POST['start_date'] ?? null;
    $end_date = $_POST['end_date'] ?: null;

    // Prepare SQL statement
    $stmt = $pdo->prepare("INSERT INTO projects (title, description, github_url, demo_url, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?)");
    
    // Execute with parameters
    $result = $stmt->execute([$title, $description, $github_url, $demo_url, $start_date, $end_date]);
    
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Project saved successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save project']);
    }
} catch (PDOException $e) {
    // Debug: Log the error
    error_log("Database Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} 