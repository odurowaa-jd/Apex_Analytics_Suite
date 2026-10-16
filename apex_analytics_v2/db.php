<?php
require_once __DIR__ . '/config.php';

// Turn off mysqli's exceptions so a bad connection shows a clear
// message instead of a blank HTTP 500 page.
mysqli_report(MYSQLI_REPORT_OFF);

function db_connect(): ?mysqli {
    $conn = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_errno) {
        return null;
    }
    $conn->set_charset('utf8mb4');
    return $conn;
}
