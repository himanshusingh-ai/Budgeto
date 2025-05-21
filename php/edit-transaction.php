<?php
session_start();
header('Content-Type: application/json');
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$type = $data['type'];
$category = $data['category'];
$amount = $data['amount'];
$note = $data['note'];
$date = $data['date'];
$email = $_SESSION['email'];

$stmt = $conn->prepare("UPDATE transactions SET type=?, category=?, amount=?, note=?, date=? WHERE id=? AND email=?");
$stmt->bind_param("ssdssis", $type, $category, $amount, $note, $date, $id, $email);

echo json_encode(['success' => $stmt->execute()]);
