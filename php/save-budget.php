<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['email'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['budget']) || !is_numeric($data['budget'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid budget']);
    exit;
}

require 'db.php';

$user_email = $_SESSION['email'];
$budget = floatval($data['budget']);

$query = "SELECT budget FROM budgets WHERE user_email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $updateQuery = "UPDATE budgets SET budget = ? WHERE user_email = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ds", $budget, $user_email);
    $success = $updateStmt->execute();
} else {
    $insertQuery = "INSERT INTO budgets (user_email, budget) VALUES (?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("sd", $user_email, $budget);
    $success = $insertStmt->execute();
}

echo json_encode(['success' => $success]);
