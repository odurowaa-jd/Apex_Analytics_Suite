<?php
// 1. LOAD THE DATA FIRST
$jsonData = file_get_contents('data.json');
$data = json_decode($jsonData, true);

// 2. CREATE THE ARRAYS FOR THE GRAPH
$months = [];
$loans = [];
$defaults = [];

foreach ($data as $row) {
    $months[] = $row['month'];
    $loans[] = $row['loans_issued'];
    $defaults[] = $row['defaults'];
}

// 3. NOW RUN THE AI INSIGHT ENGINE (Because $loans now exists!)
$total_loans = array_sum($loans);
$total_defaults = array_sum($defaults);
$avg_default_rate = ($total_defaults / $total_loans) * 100;

// Get the trend: Is it getting worse or better?
$first_month_defaults = $data[0]['defaults'];
$last_month_defaults = end($data)['defaults'];

if ($last_month_defaults > $first_month_defaults) {
    $ai_status = "Risk Warning";
    $ai_message = "Defaults have increased by " . round((($last_month_defaults - $first_month_defaults) / $first_month_defaults) * 100) . "% since January. Immediate credit policy review is recommended.";
    $color = "#e74c3c";
} else {
    $ai_status = "Healthy Growth";
    $ai_message = "Portfolio performance is stable. The current default rate of " . round($avg_default_rate, 2) . "% is within the bank's safety threshold.";
    $color = "#27ae60";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CBG Data Dashboard | Jessica's Portfolio</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; padding: 20px; }
        .container { max-width: 900px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        .stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .card { background: #3498db; color: white; padding: 20px; border-radius: 8px; text-align: center; }
    </style>
</head>
<body>

<div class="container">
   
<div class="container">
    <span style="background: #95a5a6; color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.8em; float: right;">V1.0: LEGACY JSON MODEL</span>
    <h2>Apex Analytics (Prototype)</h2>
    <p style="color: #7f8c8d;">Status: Static Data Integration</p>
    
</div> 
    
    <div class="stats-grid">
        <div class="card">
            <h3>Total Loans Issued</h3>
            <p>GHS <?php echo number_format(array_sum($loans)); ?></p>
        </div>
        <div class="card" style="background: #e74c3c;">
            <h3>Default Rate (Avg)</h3>
            <p><?php echo round((array_sum($defaults) / array_sum($loans)) * 100, 2); ?>%</p>
        </div>
    </div>

    <!-- The Chart Canvas -->
    <canvas id="loanChart"></canvas>


    <div style="margin-top: 30px; border-left: 5px solid <?php echo $color; ?>; background: #f9f9f9; padding: 20px; border-radius: 5px;">
    <h4 style="margin: 0; color: <?php echo $color; ?>; text-transform: uppercase; font-size: 0.8em; letter-spacing: 1px;">
        🤖 AI Analyst Insights
    </h4>
    <p style="font-size: 1.1em; color: #2c3e50; margin-top: 10px;">
        <strong>Status: <?php echo $ai_status; ?></strong><br>
        <?php echo $ai_message; ?>
    </p>
    <small style="color: #7f8c8d; font-style: italic;">
        *Generated based on simulated CBG transaction data using automated PHP trend analysis.
    </small>
</div>

</div>

<script>
    const ctx = document.getElementById('loanChart').getContext('2d');
    const loanChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($months); ?>,
            datasets: [{
                label: 'Monthly Loans Issued (GHS)',
                data: <?php echo json_encode($loans); ?>,
                borderColor: '#3498db',
                fill: false,
                tension: 0.1
            }, {
                label: 'Monthly Defaults (GHS)',
                data: <?php echo json_encode($defaults); ?>,
                borderColor: '#e74c3c',
                fill: false
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });
</script>

</body>
</html>