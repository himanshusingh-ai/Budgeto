<?php
session_start();
header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])) {
    // Add this line to log unauthorized access to your PHP error log
    error_log("Unauthorized access to get-category-summary.php");
    
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$userId = $_SESSION['user_id'];
include 'db_connect.php';

// Group expense by category with sum
$sql = "SELECT category, SUM(amount) as total FROM transactions WHERE user_id=? AND type='expense' GROUP BY category";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$categories = [];
while($row = $result->fetch_assoc()) {
    $categories[] = ['category' => $row['category'], 'total' => $row['total']];
}

echo json_encode($categories);
?>
