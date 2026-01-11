<?php
session_start();

// 1. If not logged in, go to login
if (!isset($_SESSION['user_ID'])) {
    header("Location: /QTrace-Website/login");
    exit();
}

// 2. Timeout Logic (10 seconds)
$timeout_duration = 300;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: /QTrace-Website/login?timeout");
    exit();
}
$_SESSION['last_activity'] = time();

// 3. Page Access Control
$current_page = basename($_SERVER['PHP_SELF']);

if ($_SESSION['role'] != 'admin') {
    // Admin cannot access home.php
    header("Location: /QTrace-Website/home");
    exit();

}
?>