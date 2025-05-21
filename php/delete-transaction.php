<?php
session_start();
header('Content-Type: application/json');
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$email = $_SESSION['email'];

$stmt = $conn->prepare("DELETE FROM transactions WHERE id = ? AND email = ?");
$stmt->bind_param("is", $id, $email);

echo json_encode(['success' => $stmt->execute()]);
