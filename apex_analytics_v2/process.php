<?php
// 1. Connection
$conn = new mysqli("localhost", "root", "mysql", "apex_analytics");

// 2. Get data from the form
$month = $_POST['month_name'];
$loans = $_POST['loans_issued'];
$repay = $_POST['repayments'];
$def = $_POST['defaults'];

// 3. The SQL Query
$sql = "INSERT INTO financial_data (month_name, loans_issued, repayments, defaults) 
        VALUES ('$month', $loans, $repay, $def)";

if ($conn->query($sql) === TRUE) {
    // Redirect back to the dashboard to see the new bar!
    header("Location: index.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>