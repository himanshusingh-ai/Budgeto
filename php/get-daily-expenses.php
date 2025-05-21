<?php
session_start();
require 'config.php';

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
  echo json_encode(["labels" => [], "values" => []]);
  exit;
}

$sql = "SELECT DATE(date) as day, SUM(amount) as total FROM transactions 
        WHERE user_id = ? AND type = 'expense' AND date >= DATE_SUB(CURDATE(), INTERVAL 90 DAY)
        GROUP BY DATE(date) ORDER BY DATE(date) ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

$labels = [];
$values = [];

while ($row = $result->fetch_assoc()) {
  $labels[] = $row['day'];
  $values[] = round($row['total'], 2);
}

echo json_encode(["labels" => $labels, "values" => $values]);
