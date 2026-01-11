<?php

if (!isset($_GET['admin']) || $_GET['admin'] !== 'true') {
    header("Location: /QTrace-Website/home"); 
    exit();
}else {
    header("Location: /QTrace-Website/login"); 
    exit();
}
?>

