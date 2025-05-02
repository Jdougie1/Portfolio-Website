<?php
require_once 'config.php';

$requiredFields = ['name', 'proficiency'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        validateRequiredFields($requiredFields, $_POST);
        
        $stmt = $pdo->prepare("
            INSERT INTO skills (name, category, proficiency)
            VALUES (:name, :category, :proficiency)
        ");
        
        $stmt->execute([
            'name' => $_POST['name'],
            'category' => $_POST['category'] ?? null,
            'proficiency' => $_POST['proficiency']
        ]);
        
        sendResponse(true, ['id' => $pdo->lastInsertId()], "Skill added successfully");
    } catch (PDOException $e) {
        sendResponse(false, null, "Database error: " . $e->getMessage());
    }
} else {
    sendResponse(false, null, "Invalid request method");
} 