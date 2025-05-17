<?php
session_start();
header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$userId = $_SESSION['user_id'];
include 'db_connect.php'; // Your DB connection

// Query total income
$incomeSql = "SELECT IFNULL(SUM(amount),0) as total_income FROM transactions WHERE user_id=? AND type='income'";
$stmt = $conn->prepare($incomeSql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalIncome = $row['total_income'];

// Query total expense
$expenseSql = "SELECT IFNULL(SUM(amount),0) as total_expense FROM transactions WHERE user_id=? AND type='expense'";
$stmt = $conn->prepare($expenseSql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalExpense = $row['total_expense'];

// Calculate balance
$balance = $totalIncome - $totalExpense;

echo json_encode([
    'totalIncome' => $totalIncome,
    'totalExpense' => $totalExpense,
    'balance' => $balance
]);
?>
