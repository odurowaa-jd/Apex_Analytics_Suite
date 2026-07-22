<!DOCTYPE html>
<html>
<head>
    <title>Apex V2 | Admin Entry</title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .form-card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 400px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .back-link { display: block; text-align: center; margin-top: 15px; color: #7f8c8d; text-decoration: none; font-size: 0.9em; }
    </style>
</head>
<body>

<div class="form-card">
    <h3>📥 Add Monthly Data</h3>
    <form action="process.php" method="POST">
        <input type="text" name="month_name" placeholder="Month Name (e.g. April)" required>
        <input type="number" name="loans_issued" placeholder="Total Loans Issued" required>
        <input type="number" name="repayments" placeholder="Total Repayments" required>
        <input type="number" name="defaults" placeholder="Total Defaults" required>
        <button type="submit">Submit to SQL Database</button>
    </form>
    <a href="index.php" class="back-link">← Back to Dashboard</a>
</div>

</body>
</html>