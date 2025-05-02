<?php
// config.php
session_start();

// Database credentials for InfinityFree
$host = 'sql112.infinityfree.com';
$dbname = 'if0_38883049_josephportfolio';
$username = 'if0_38883049';
$password = 'Personal321123';

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}