<!-- index.php -->
<?php
require_once 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joseph Zhu - B.S. Computer Science/University of Central Florida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/nav.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center text-white">
            <h1 class="display-4 mb-4">Why Choose Me for Toptech Systems?</h1>
            <p class="lead mb-5">Here are a couple reasons why:</p>
            <a href="about.php" class="begin-btn">Begin Journey</a>
        </div>
    </section>

    <!-- Rest of your content -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>