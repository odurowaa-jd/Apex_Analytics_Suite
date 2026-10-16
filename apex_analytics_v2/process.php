<?php
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: add_data.php');
    exit;
}

// Only someone with the admin password can add data
$given = $_POST['admin_password'] ?? '';
if (!hash_equals(ADMIN_PASSWORD, $given)) {
    header('Location: add_data.php?status=auth');
    exit;
}

$month = trim($_POST['month_name'] ?? '');
$loans = filter_var($_POST['loans_issued'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
$repay = filter_var($_POST['repayments'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
$defs  = filter_var($_POST['defaults'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);

if ($month === '' || mb_strlen($month) > 30 || $loans === false || $repay === false || $defs === false) {
    header('Location: add_data.php?status=bad');
    exit;
}

$conn = db_connect();
if (!$conn) {
    header('Location: add_data.php?status=db');
    exit;
}

$stmt = $conn->prepare("INSERT INTO `monthly_data` (`month_name`, `loans_issued`, `repayments`, `defaults`) VALUES (?, ?, ?, ?)");
if (!$stmt || !$stmt->bind_param('siii', $month, $loans, $repay, $defs) || !$stmt->execute()) {
    header('Location: add_data.php?status=db');
    exit;
}

header('Location: add_data.php?status=ok');
exit;
