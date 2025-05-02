<?php
require_once 'config.php';

$requiredFields = ['title', 'company', 'start_date'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        validateRequiredFields($requiredFields, $_POST);
        
        $stmt = $pdo->prepare("
            INSERT INTO experiences (title, company, location, start_date, end_date, description)
            VALUES (:title, :company, :location, :start_date, :end_date, :description)
        ");
        
        $stmt->execute([
            'title' => $_POST['title'],
            'company' => $_POST['company'],
            'location' => $_POST['location'] ?? null,
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'] ?? null,
            'description' => $_POST['description'] ?? null
        ]);
        
        sendResponse(true, ['id' => $pdo->lastInsertId()], "Experience added successfully");
    } catch (PDOException $e) {
        sendResponse(false, null, "Database error: " . $e->getMessage());
    }
} else {
    sendResponse(false, null, "Invalid request method");
} 