<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['email'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

require 'db.php'; // Your database connection file

$user_email = $_SESSION['email'];

$totalIncome = 0;
$totalExpenses = 0;

$query = "SELECT type, SUM(amount) as total FROM transactions WHERE email = ? GROUP BY type";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    if ($row['type'] === 'income') {
        $totalIncome = (float)$row['total'];
    } elseif ($row['type'] === 'expense') {
        $totalExpenses = (float)$row['total'];
    }
}

$balance = $totalIncome - $totalExpenses;

echo json_encode([
    'totalIncome' => $totalIncome,
    'totalExpenses' => $totalExpenses,
    'balance' => $balance
]);
