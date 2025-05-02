<?php
require_once '../config.php';
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

if (!isset($_SESSION['is_admin'])) {
    die(json_encode(['success' => false, 'message' => 'Unauthorized']));
}

try {
    $pdo->beginTransaction();

    // Handle image upload if present
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../assets/images/';
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $fileName;
        
        // Validate and move the file
        if (!in_array($_FILES['image']['type'], ['image/jpeg', 'image/png', 'image/gif'])) {
            throw new Exception('Only JPG, PNG & GIF files are allowed.');
        }
        
        if ($_FILES['image']['size'] > 5000000) {
            throw new Exception('File is too large. Maximum size is 5MB.');
        }
        
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            throw new Exception('Failed to upload image.');
        }
        
        // Update image URL in database
        $stmt = $pdo->prepare("UPDATE about SET image_url = ? WHERE id = 1");
        $stmt->execute(['assets/images/' . $fileName]);
    }
    
    // Handle about information update if present
    if (isset($_POST['name']) || isset($_POST['title']) || isset($_POST['description'])) {
        $stmt = $pdo->prepare("
            INSERT INTO about (id, name, title, description) 
            VALUES (1, :name, :title, :description)
            ON DUPLICATE KEY UPDATE 
            name = VALUES(name),
            title = VALUES(title),
            description = VALUES(description)
        ");

        $stmt->execute([
            'name' => $_POST['name'] ?? '',
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? ''
        ]);
    }

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    error_log('Save error: ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 