<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['email'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$email = $_SESSION['email'];

// DB connection (update credentials)
$host = 'localhost';
$db = 'budgeto_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(['error' => 'DB connection failed']);
    exit;
}

$insights = [];

// Helper function to fetch sum by category and month
function getCategorySum($conn, $email, $category, $month, $year) {
    $stmt = $conn->prepare("SELECT IFNULL(SUM(amount), 0) as total FROM transactions WHERE email=? AND type='expense' AND category=? AND MONTH(date)=? AND YEAR(date)=?");
    $stmt->bind_param("ssii", $email, $category, $month, $year);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return floatval($result['total']);
}

// Helper function to get total expenses by month
function getTotalExpenses($conn, $email, $month, $year) {
    $stmt = $conn->prepare("SELECT IFNULL(SUM(amount), 0) as total FROM transactions WHERE email=? AND type='expense' AND MONTH(date)=? AND YEAR(date)=?");
    $stmt->bind_param("sii", $email, $month, $year);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return floatval($result['total']);
}

// 1. Food expenses comparison
$currentMonth = date('n');
$currentYear = date('Y');
$lastMonthDate = date('Y-m-d', strtotime('first day of last month'));
$lastMonth = intval(date('n', strtotime($lastMonthDate)));
$lastYear = intval(date('Y', strtotime($lastMonthDate)));

$thisMonthFood = getCategorySum($conn, $email, 'Food', $currentMonth, $currentYear);
$lastMonthFood = getCategorySum($conn, $email, 'Food', $lastMonth, $lastYear);

if ($lastMonthFood > 0) {
    $percentChange = (($thisMonthFood - $lastMonthFood) / $lastMonthFood) * 100;
    if ($percentChange > 5) { // only report if increase >5%
        $insights[] = "You spent " . round($percentChange, 1) . "% more on food this month compared to last month.";
    }
}

// 2. Subscription expenses this month and suggestion
$thisMonthSubscriptions = getCategorySum($conn, $email, 'Subscription', $currentMonth, $currentYear);
if ($thisMonthSubscriptions > 0) {
    // Suggest saving 20% if subscriptions are high (>₹500)
    if ($thisMonthSubscriptions > 500) {
        $suggestedSavings = round($thisMonthSubscriptions * 0.2);
        $insights[] = "Consider reducing your subscriptions to save ₹$suggestedSavings/month.";
    }
}

// 3. Expense prediction for next month (average of last 3 months)
$monthYearList = [];
for ($i=1; $i<=3; $i++) {
    $date = date('Y-m-d', strtotime("-$i month"));
    $monthYearList[] = [intval(date('n', strtotime($date))), intval(date('Y', strtotime($date)))];
}

$totalLast3Months = 0;
foreach ($monthYearList as $my) {
    $totalLast3Months += getTotalExpenses($conn, $email, $my[0], $my[1]);
}
$predictedExpense = round($totalLast3Months / 3, 2);
$budgetRecommendation = round($predictedExpense * 0.9, 2); // suggest 10% less than predicted expense

// Output response
echo json_encode([
    'insights' => $insights,
    'predicted_expense' => $predictedExpense,
    'budget_recommendation' => $budgetRecommendation
]);

$conn->close();
?>
