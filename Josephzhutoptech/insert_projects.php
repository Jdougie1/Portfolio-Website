<?php
require_once 'config.php';

try {
    $stmt = $pdo->prepare("INSERT INTO projects (title, description, image_url, date, github_url, live_url) VALUES (?, ?, ?, ?, ?, ?)");
    
    // Insert first project
    $stmt->execute([
        'Portfolio Website',
        'A responsive portfolio website built with PHP, MySQL, and Bootstrap',
        'assets/images/projects/portfolio.jpg',
        '2024-03-15',
        'https://github.com/yourusername/portfolio',
        'https://yourportfolio.com'
    ]);
    
    // Insert second project
    $stmt->execute([
        'E-commerce Platform',
        'A full-featured e-commerce platform with user authentication and payment processing',
        'assets/images/projects/ecommerce.jpg',
        '2024-02-20',
        'https://github.com/yourusername/ecommerce',
        'https://yourstore.com'
    ]);
    
    echo "Sample projects inserted successfully!\n";
    
    // Verify the data
    $stmt = $pdo->query("SELECT * FROM projects");
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "\nProjects in database:\n";
    foreach ($projects as $project) {
        echo "- {$project['title']}\n";
    }
    
} catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
} 