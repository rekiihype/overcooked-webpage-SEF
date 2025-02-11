<?php

// Database credentials
$host = "localhost";
$username = "root";
$password = "";
$database = "the_overcooked_db";

// Enable MySQLi exceptions
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = mysqli_connect($host, $username, $password, $database);
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>