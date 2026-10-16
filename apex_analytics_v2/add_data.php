<?php
$status = $_GET['status'] ?? '';
$messages = [
    'ok'   => ['Data saved successfully.', '#27ae60'],
    'auth' => ['Incorrect admin password.', '#e74c3c'],
    'bad'  => ['Please check your entries and try again.', '#e74c3c'],
    'db'   => ['Could not save to the database. Check config.php and setup.sql.', '#e74c3c'],
];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apex V2 | Admin Entry</title>
    <style>
        body { font-family: 'Inter', 'Segoe UI', sans-serif; background: #f4f7f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; padding: 20px; box-sizing: border-box; }
        .form-card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 400px; max-width: 100%; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .back-link { display: block; text-align: center; margin-top: 15px; color: #7f8c8d; text-decoration: none; font-size: 0.9em; }
        .notice { padding: 10px 12px; border-radius: 5px; color: white; margin-bottom: 10px; font-size: 0.9em; }
    </style>
</head>
<body>
<div class="form-card">
    <h3>📥 Add Monthly Data</h3>
    <?php if (isset($messages[$status])): ?>
        <div class="notice" style="background: <?php echo $messages[$status][1]; ?>;">
            <?php echo htmlspecialchars($messages[$status][0]); ?>
        </div>
    <?php endif; ?>
    <form action="process.php" method="POST">
        <input type="text" name="month_name" placeholder="Month Name (e.g. July)" maxlength="30" required>
        <input type="number" name="loans_issued" placeholder="Total Loans Issued" min="0" required>
        <input type="number" name="repayments" placeholder="Total Repayments" min="0" required>
        <input type="number" name="defaults" placeholder="Total Defaults" min="0" required>
        <input type="password" name="admin_password" placeholder="Admin password" required>
        <button type="submit">Submit to SQL Database</button>
    </form>
    <a href="index.php" class="back-link">← Back to Dashboard</a>
</div>
</body>
</html>
