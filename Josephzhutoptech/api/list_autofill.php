<?php
require '../config.php';
header('Content-Type: application/json');
$exps = $pdo->query("SELECT * FROM experiences ORDER BY created_at DESC")
            ->fetchAll(PDO::FETCH_ASSOC);
$titles    = $pdo->query("SELECT DISTINCT title FROM experiences")
                 ->fetchAll(PDO::FETCH_COLUMN);
$companies = $pdo->query("SELECT DISTINCT company FROM experiences")
                 ->fetchAll(PDO::FETCH_COLUMN);
echo json_encode(['exps'=>$exps,'titles'=>$titles,'companies'=>$companies]);
