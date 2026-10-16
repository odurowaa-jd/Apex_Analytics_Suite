<?php
require_once __DIR__ . '/db.php';

$conn = db_connect();
$error = null;
$rows = [];

if (!$conn) {
    $error = "Could not connect to the database. Check the details in config.php.";
} else {
    $result = $conn->query("SELECT `month_name`, `loans_issued`, `repayments`, `defaults` FROM `monthly_data` ORDER BY `id` ASC");
    if ($result === false) {
        $error = "The monthly_data table was not found. Import setup.sql in phpMyAdmin first.";
    } else {
        while ($r = $result->fetch_assoc()) { $rows[] = $r; }
    }
}

$months = array_column($rows, 'month_name');
$loans = array_map('intval', array_column($rows, 'loans_issued'));
$repayments = array_map('intval', array_column($rows, 'repayments'));
$defaults = array_map('intval', array_column($rows, 'defaults'));

$total_loans = array_sum($loans);
$total_repay = array_sum($repayments);
$total_defaults = array_sum($defaults);
$default_rate = $total_loans > 0 ? ($total_defaults / $total_loans) * 100 : 0;
$repay_rate = $total_loans > 0 ? ($total_repay / $total_loans) * 100 : 0;

// Insight engine: compare the latest month against the first recorded month
$ai_status = "Awaiting Data";
$ai_message = "Add monthly figures to generate insights.";
$color = "#95a5a6";

if (count($rows) >= 2) {
    $first = $defaults[0];
    $last = end($defaults);
    $first_month = $months[0];
    if ($last > $first) {
        $change = $first > 0 ? round((($last - $first) / $first) * 100) . "%" : "a notable amount";
        $ai_status = "Risk Warning";
        $ai_message = "Defaults have increased by " . $change . " since " . $first_month . ". Immediate credit policy review is recommended.";
        $color = "#e74c3c";
    } else {
        $ai_status = "Healthy Growth";
        $ai_message = "Portfolio performance is stable. The current default rate of " . round($default_rate, 2) . "% is within the bank's safety threshold.";
        $color = "#27ae60";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apex Analytics V2 | Jessica's Portfolio</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; padding: 20px; }
        .container { max-width: 900px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        .stats-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .card { background: #3498db; color: white; padding: 20px; border-radius: 8px; text-align: center; }
        .card h3 { margin-top: 0; font-size: 1em; }
        .links { display: flex; justify-content: space-between; margin-top: 25px; font-size: 0.9em; }
        .links a { color: #3498db; text-decoration: none; font-weight: 600; }
        .error { background: #fdecea; color: #c0392b; padding: 15px; border-radius: 6px; margin-bottom: 20px; }
        @media (max-width: 700px) { .stats-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<div class="container">
    <span style="background: #27ae60; color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.8em; float: right;">V2.0: LIVE SQL MODEL</span>
    <h2>Apex Analytics Suite</h2>
    <p style="color: #7f8c8d;">Status: Live Database Integration</p>

    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="stats-grid">
        <div class="card">
            <h3>Total Loans Issued</h3>
            <p>GHS <?php echo number_format($total_loans); ?></p>
        </div>
        <div class="card" style="background: #27ae60;">
            <h3>Repayment Rate</h3>
            <p><?php echo round($repay_rate, 2); ?>%</p>
        </div>
        <div class="card" style="background: #e74c3c;">
            <h3>Default Rate (Avg)</h3>
            <p><?php echo round($default_rate, 2); ?>%</p>
        </div>
    </div>

    <canvas id="loanChart"></canvas>

    <div style="margin-top: 30px; border-left: 5px solid <?php echo $color; ?>; background: #f9f9f9; padding: 20px; border-radius: 5px;">
        <h4 style="margin: 0; color: <?php echo $color; ?>; text-transform: uppercase; font-size: 0.8em; letter-spacing: 1px;">
            🤖 AI Analyst Insights
        </h4>
        <p style="font-size: 1.1em; color: #2c3e50; margin-top: 10px;">
            <strong>Status: <?php echo htmlspecialchars($ai_status); ?></strong><br>
            <?php echo htmlspecialchars($ai_message); ?>
        </p>
        <small style="color: #7f8c8d; font-style: italic;">
            *Generated from simulated CBG transaction data stored in MySQL using automated PHP trend analysis.
        </small>
    </div>

    <div class="links">
        <a href="../">← Switch version</a>
        <a href="add_data.php">Add monthly data →</a>
    </div>
</div>

<script>
    const ctx = document.getElementById('loanChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($months); ?>,
            datasets: [{
                label: 'Monthly Loans Issued (GHS)',
                data: <?php echo json_encode($loans); ?>,
                borderColor: '#3498db', fill: false, tension: 0.1
            }, {
                label: 'Monthly Repayments (GHS)',
                data: <?php echo json_encode($repayments); ?>,
                borderColor: '#27ae60', fill: false, tension: 0.1
            }, {
                label: 'Monthly Defaults (GHS)',
                data: <?php echo json_encode($defaults); ?>,
                borderColor: '#e74c3c', fill: false
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });
</script>
</body>
</html>
