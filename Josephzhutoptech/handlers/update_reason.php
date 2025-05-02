<?php
require_once '../config.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['is_admin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE whychooseme SET title = :title, description = :description WHERE id = :id");
    $stmt->execute([
        'id' => $_POST['id'],
        'title' => $_POST['title'],
        'description' => $_POST['description']
    ]);
    
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} 