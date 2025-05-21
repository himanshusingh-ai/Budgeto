<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['email'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

require 'db.php';

$user_email = $_SESSION['email'];

$query = "SELECT category, SUM(amount) as total FROM transactions WHERE email = ? AND type='expense' GROUP BY category";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

$categories = [];
$amounts = [];

while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
    $amounts[] = (float)$row['total'];
}

echo json_encode([
    'categories' => $categories,
    'amounts' => $amounts
]);
