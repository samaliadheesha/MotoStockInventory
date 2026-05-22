<?php
// includes/config.php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');          // default XAMPP user
define('DB_PASS', '');              // default XAMPP has no password
define('DB_NAME', 'motostock26');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: set charset
$conn->set_charset("utf8mb4");