<?php
require_once '../config.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['is_admin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM experiences WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $experience = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($experience) {
        echo json_encode($experience);
    } else {
        echo json_encode(['success' => false, 'message' => 'Experience not found']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} 