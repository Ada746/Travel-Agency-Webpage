<?php
// Copy this file to config.php and fill in your own values.
// config.php is listed in .gitignore and must never be committed.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = getenv('DB_HOST') ?: 'localhost';
$db   = getenv('DB_NAME') ?: 'your_database';
$user = getenv('DB_USER') ?: 'your_user';
$pass = getenv('DB_PASS') ?: 'your_password';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection error");
}
$conn->set_charset('utf8mb4');
