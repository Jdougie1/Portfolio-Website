<?php
require_once __DIR__ . '/../config.php';

try {
    // Read and execute about.sql
    $about_sql = file_get_contents(__DIR__ . '/about.sql');
    $pdo->exec($about_sql);
    echo "About table created successfully\n";

    // Read and execute skills.sql
    $skills_sql = file_get_contents(__DIR__ . '/skills.sql');
    $pdo->exec($skills_sql);
    echo "Skills table created successfully\n";

    // Read and execute experiences.sql
    $experiences_sql = file_get_contents(__DIR__ . '/experiences.sql');
    $pdo->exec($experiences_sql);
    echo "Experiences table created successfully\n";

    // Read and execute whychooseme.sql
    $whychooseme_sql = file_get_contents(__DIR__ . '/whychooseme.sql');
    $pdo->exec($whychooseme_sql);
    echo "Why Choose Me table created successfully\n";

    // Read and execute projects.sql
    $projects_sql = file_get_contents(__DIR__ . '/projects.sql');
    $pdo->exec($projects_sql);
    echo "Projects table created successfully\n";

} catch (PDOException $e) {
    die("Error creating tables: " . $e->getMessage());
} 