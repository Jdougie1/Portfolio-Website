<?php
require_once '../config.php';

try {
    // Check if skills table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'skills'");
    if ($stmt->rowCount() === 0) {
        echo "Skills table does not exist. Creating it now...\n";
        
        // Read and execute skills.sql
        $sql = file_get_contents(__DIR__ . '/skills.sql');
        $pdo->exec($sql);
        
        echo "Skills table created successfully!\n";
    } else {
        echo "Skills table exists.\n";
    }

    // Check table structure
    $stmt = $pdo->query("DESCRIBE skills");
    echo "\nSkills table structure:\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "{$row['Field']} - {$row['Type']}\n";
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
} 