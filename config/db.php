<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db   = "smart_ai_clothing";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database Connection Failed");
}

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
