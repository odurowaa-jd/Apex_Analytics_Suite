<?php /* Landing page: choose a version */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apex Analytics Suite | Jessica's Portfolio</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; padding: 20px; }
        .container { max-width: 900px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 25px; }
        a.card { display: block; text-decoration: none; color: white; background: #3498db; padding: 25px; border-radius: 8px; }
        a.card.v1 { background: #95a5a6; }
        a.card h3 { margin: 0 0 8px; }
        a.card p { margin: 0; font-size: 0.9em; opacity: 0.95; }
        @media (max-width: 600px) { .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<div class="container">
    <h2>Apex Analytics Suite</h2>
    <p style="color:#7f8c8d;">Branch lending visibility dashboard. Choose a version to explore.</p>
    <div class="grid">
        <a class="card v1" href="v1/"><h3>Version 1</h3><p>Legacy prototype powered by a static JSON file.</p></a>
        <a class="card" href="v2/"><h3>Version 2</h3><p>Live SQL model with a data entry form and trend insights.</p></a>
    </div>
</div>
</body>
</html>
