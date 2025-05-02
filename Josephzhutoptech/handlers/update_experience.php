<?php
require_once '../config.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['is_admin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE experiences 
                          SET title = :title, 
                              company = :company, 
                              location = :location, 
                              start_date = :start_date, 
                              end_date = :end_date, 
                              description = :description 
                          WHERE id = :id");
    
    $stmt->execute([
        'id' => $_POST['id'],
        'title' => $_POST['title'],
        'company' => $_POST['company'],
        'location' => $_POST['location'],
        'start_date' => $_POST['start_date'],
        'end_date' => !empty($_POST['end_date']) ? $_POST['end_date'] : null,
        'description' => $_POST['description']
    ]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} 