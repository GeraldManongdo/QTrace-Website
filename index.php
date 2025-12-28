<?php

if (!isset($_GET['admin']) || $_GET['admin'] !== 'true') {
    header("Location: pages/public/home.php"); 
    exit();
}else {
    header("Location: pages/admin/dashboard.php"); 
    exit();
}
?>
