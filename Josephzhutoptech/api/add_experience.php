<?php
require '../config.php';
header('Content-Type: application/json');
$stmt = $pdo->prepare(
  "INSERT INTO experiences
   (title,company,start_date,end_date,description)
   VALUES (?,?,?,?,?)"
);
$ok = $stmt->execute([
  $_POST['title'],
  $_POST['company'],
  $_POST['start_date'],
  $_POST['end_date']?:null,
  $_POST['description']
]);
echo json_encode(['success'=>(bool)$ok]);
