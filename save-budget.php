<?php
session_start();
header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$userId = $_SESSION['user_id'];
include 'db_connect.php';

$budget = $_POST['budget'] ?? null;

if($budget === null || !is_numeric($budget)) {
    echo json_encode(['error' => 'Invalid budget value']);
    exit;
}

// Check if budget record exists
$checkSql = "SELECT id FROM budgets WHERE user_id=?";
$stmt = $conn->prepare($checkSql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0) {
    // Update budget
    $updateSql = "UPDATE budgets SET amount=? WHERE user_id=?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("di", $budget, $userId);
    $stmt->execute();
} else {
    // Insert new budget
    $insertSql = "INSERT INTO budgets (user_id, amount) VALUES (?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("id", $userId, $budget);
    $stmt->execute();
}

echo json_encode(['success' => true, 'budget' => $budget]);
?>
