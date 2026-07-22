<?php
// 1. DATABASE CONNECTION
$servername = "localhost";
$username = "root";
$password = "mysql"; // Password for AMPPS
$dbname = "apex_analytics";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. FETCH DATA FROM SQL
$sql = "SELECT month_name, loans_issued, defaults FROM financial_data";
$result = $conn->query($sql);

$months = [];
$loans = [];
$defaults = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $months[] = $row['month_name'];
        $loans[] = $row['loans_issued'];
        $defaults[] = $row['defaults'];
    }
}

// 3. AI INSIGHT LOGIC (The "Brain")
$total_loans = array_sum($loans);
$total_defaults = array_sum($defaults);
$first_month_defaults = $defaults[0];
$last_month_defaults = end($defaults);

if ($last_month_defaults > $first_month_defaults) {
    $ai_status = "Risk Warning";
    $ai_message = "SQL analysis detected a trend increase in defaults. Immediate policy review recommended.";
    $color = "#e74c3c";
} else {
    $ai_status = "Healthy Growth";
    $ai_message = "Relational data indicates stable recovery margins.";
    $color = "#27ae60";
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Apex Analytics v2.0 | SQL-Powered</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7f6; padding: 40px; }
        .container { max-width: 900px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        h2 { color: #2c3e50; border-bottom: 3px solid #3498db; display: inline-block; }
        .badge { background: #3498db; color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.8em; float: right; }
    </style>
</head>
<body>

<div class="container">
    <span class="badge">V2.0: SQL DATABASE INTEGRATED</span>
    <h2>Apex Financial Insights</h2>
    <p style="color: #7f8c8d;">Data Source: Local MySQL Relational Database</p>
    
    <canvas id="loanChart" style="margin-top: 20px;"></canvas>

    <div style="margin-top: 30px; border-left: 5px solid <?php echo $color; ?>; background: #f9f9f9; padding: 20px;">
        <h4 style="margin: 0; color: <?php echo $color; ?>;">🤖 AI HEURISTIC ENGINE</h4>
        <p><strong>Status: <?php echo $ai_status; ?></strong><br><?php echo $ai_message; ?></p>
    </div>
</div>

<script>
    const ctx = document.getElementById('loanChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($months); ?>,
            datasets: [{
                label: 'Capital Deployed (GHS)',
                data: <?php echo json_encode($loans); ?>,
                backgroundColor: '#3498db'
            }]
        }
    });
</script>

</body>
</html>