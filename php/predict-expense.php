<?php
session_start();
header('Content-Type: application/json');

// DB connection
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'budgeto';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  echo json_encode(['error' => 'DB connection failed']);
  exit;
}

$user_id = $_SESSION['user_id'] ?? 0;

if (!$user_id) {
  echo json_encode(['error' => 'User not logged in']);
  exit;
}

// Calculate avg of last 3 months
$months = [];
for ($i = 1; $i <= 3; $i++) {
  $months[] = date('Y-m', strtotime("-$i month"));
}

$total = 0;
$count = 0;

foreach ($months as $m) {
  $start = "$m-01";
  $end = date("Y-m-t", strtotime($start));

  $sql = "SELECT SUM(amount) as total FROM transactions 
          WHERE user_id=? AND type='expense' AND date BETWEEN ? AND ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iss", $user_id, $start, $end);
  $stmt->execute();
  $stmt->bind_result($month_total);
  $stmt->fetch();
  $stmt->close();

  if ($month_total) {
    $total += $month_total;
    $count++;
  }
}

$avg = ($count > 0) ? round($total / $count) : 0;
$recommend = round($avg * 0.9); // Suggest 10% lower than average

echo json_encode([
  'predicted_expense' => $avg,
  'budget_recommendation' => $recommend
]);
