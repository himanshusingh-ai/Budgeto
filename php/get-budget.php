<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['email'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

require 'db.php';

$user_email = $_SESSION['email'];

$query = "SELECT budget FROM budgets WHERE user_email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

$budget = 0;
if ($row = $result->fetch_assoc()) {
    $budget = (float)$row['budget'];
}

echo json_encode(['budget' => $budget]);
