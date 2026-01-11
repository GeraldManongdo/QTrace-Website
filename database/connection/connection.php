<?php


// Database configuration
$host     = "localhost";
$username = "root";
$password = "";
$dbname   = "qtrace";
$_SESSION['success'] = "";

// Enable mysqli error reporting for easier debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Create connection
    $conn = new mysqli($host, $username, $password, $dbname);

    // Set charset to utf8mb4 for special character support
    $conn->set_charset("utf8mb4");

} catch (mysqli_sql_exception $e) {
    // If connection fails, stop the script and show the error
    die("Connection failed: " . $e->getMessage());
}


?>