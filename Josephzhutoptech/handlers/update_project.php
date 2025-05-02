<?php
require_once '../config.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['is_admin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

try {
    // Get form data
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $github_url = $_POST['github_url'];
    $demo_url = $_POST['demo_url'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Prepare SQL statement
    $stmt = $pdo->prepare("UPDATE projects SET title = ?, description = ?, github_url = ?, demo_url = ?, start_date = ?, end_date = ? WHERE id = ?");
    
    // Execute with parameters
    $stmt->execute([$title, $description, $github_url, $demo_url, $start_date, $end_date, $id]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} 