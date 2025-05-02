<?php
require_once '../config.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['is_admin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM skills WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $skill = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($skill) {
        echo json_encode($skill);
    } else {
        echo json_encode(['success' => false, 'message' => 'Skill not found']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} 