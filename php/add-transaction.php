<?php
session_start();
header('Content-Type: application/json');
require 'db.php';

if (!isset($_SESSION['email'])) {
  http_response_code(401);
  echo json_encode(['error' => 'Unauthorized']);
  exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$type = $data['type'];
$category = $data['category'];
$amount = $data['amount'];
$note = $data['note'];
$date = $data['date'];
$email = $_SESSION['email'];

$stmt = $conn->prepare("INSERT INTO transactions (email, type, category, amount, note, date) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $email, $type, $category, $amount, $note, $date);

if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['error' => 'Insert failed']);
}
