<?php
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=portfolio;charset=utf8mb4",
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "Connected to database successfully!\n";
    
    // Check if projects table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'projects'");
    if ($stmt->rowCount() === 0) {
        echo "Projects table does not exist.\n";
    } else {
        echo "Projects table exists.\n";
        
        // Check table structure
        $stmt = $pdo->query("DESCRIBE projects");
        echo "\nProjects table structure:\n";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "{$row['Field']} - {$row['Type']}\n";
        }
        
        // Check if there are any projects
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM projects");
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        echo "\nNumber of projects in database: " . $count . "\n";
        
        if ($count > 0) {
            $stmt = $pdo->query("SELECT * FROM projects");
            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "\nProjects:\n";
            foreach ($projects as $project) {
                echo "- {$project['title']}\n";
            }
        }
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
} 