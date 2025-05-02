<?php
require_once __DIR__ . '/../config.php';

try {
    // Read the SQL file
    $sql = file_get_contents(__DIR__ . '/projects.sql');
    
    // Execute the SQL
    $pdo->exec($sql);
    
    echo "Projects table recreated successfully.\n";
    
    // Verify the table structure
    $stmt = $pdo->query("DESCRIBE projects");
    echo "\nTable structure:\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "{$row['Field']} - {$row['Type']}\n";
    }
    
    // Check if sample data was inserted
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM projects");
    $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "\nNumber of projects: " . $count . "\n";
    
} catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
} 