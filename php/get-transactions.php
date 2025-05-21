<?php
session_start();
header('Content-Type: application/json');
require 'db.php';

$email = $_SESSION['email'] ?? '';
$id = $_GET['id'] ?? null;

if (!$email) {
  http_response_code(401);
  echo json_encode(['error' => 'Unauthorized']);
  exit;
}

if ($id) {
  $stmt = $conn->prepare("SELECT * FROM transactions WHERE id = ? AND email = ?");
  $stmt->bind_param("is", $id, $email);
  $stmt->execute();
  $result = $stmt->get_result();
  echo json_encode(['transaction' => $result->fetch_assoc()]);
  exit;
}

$stmt = $conn->prepare("SELECT * FROM transactions WHERE email = ? ORDER BY date DESC");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$transactions = [];
while ($row = $result->fetch_assoc()) {
  $transactions[] = $row;
}
echo json_encode(['transactions' => $transactions]);
