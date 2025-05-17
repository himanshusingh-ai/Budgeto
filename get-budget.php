<?php
session_start();
header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$userId = $_SESSION['user_id'];
include 'db_connect.php';

$sql = "SELECT amount FROM budgets WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if($row = $result->fetch_assoc()) {
    echo json_encode(['budget' => $row['amount']]);
} else {
    echo json_encode(['budget' => null]);
}
?>
